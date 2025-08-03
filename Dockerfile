# Etapa 1: Construir assets con Node
FROM node:20 as node

WORKDIR /app

# Copiar configuraciones necesarias para Vite
COPY package*.json vite.config.js ./
COPY tailwind.config.js postcss.config.js ./

RUN npm install

# Copiar recursos para compilar
COPY resources ./resources
COPY public ./public

# Compilar assets
RUN npm run build

# -------------------------------------------------------------------------

# Etapa 2: PHP con Apache
FROM php:8.2-apache

# Instalar dependencias necesarias de PHP
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    libpq-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto completo (excluye .env, Render usa variables de entorno)
COPY . .

# Copiar assets ya construidos desde etapa Node
COPY --from=node /app/public/build ./public/build

# Instalar dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Limpiar cachés de Laravel
RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan route:clear || true

# Crear symlink para que /storage apunte a storage/app/public
RUN php artisan storage:link

# Permisos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configuración del VirtualHost de Apache
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf
