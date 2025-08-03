# Etapa 1: Construir assets con Node
FROM node:20 as node

WORKDIR /app

# Copiar config y dependencias
COPY package*.json vite.config.js ./
COPY tailwind.config.js postcss.config.js ./

RUN npm install

# Copiar archivos necesarios para compilar assets
COPY resources ./resources
COPY public ./public

# Compilar los assets (Vite)
RUN npm run build

# -------------------------------------------------------------------------

# Etapa 2: PHP con Apache
FROM php:8.2-apache

# Instalar dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    libpq-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Definir directorio de trabajo
WORKDIR /var/www/html

# Copiar el proyecto completo (código PHP, rutas, etc.)
COPY . .

# Copiar assets construidos desde la etapa de Node
COPY --from=node /app/public/build ./public/build

# Instalar dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Limpiar cachés de Laravel para evitar errores
RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan route:clear

# Dar permisos adecuados a Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configurar Apache para servir desde /public
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf
