# Etapa 1: Compilar assets con Node
FROM node:20 as node

WORKDIR /app

# Copia los archivos de Vite
COPY package*.json vite.config.js ./
RUN npm install

# Copia el resto del proyecto (para acceder a los CSS/JS)
COPY resources ./resources
COPY public ./public

# Si tienes Tailwind o Vue, copia también:
COPY tailwind.config.js ./
COPY postcss.config.js ./

# Compila los assets
RUN npm run build


# Etapa 2: Imagen final con Apache y PHP
FROM php:8.2-apache

# Instala extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libpng-dev libonig-dev libxml2-dev libpq-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Habilita mod_rewrite
RUN a2enmod rewrite

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copia todo el proyecto
COPY . .

# Copia los assets construidos en la etapa anterior
COPY --from=node /app/public/build ./public/build

# Instala dependencias PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader


# Instalar dependencias Node y construir los assets
RUN npm install && npm run build

# Permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configura el VirtualHost de Apache
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf
