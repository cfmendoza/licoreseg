# Usa una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala dependencias del sistema y extensiones necesarias de PHP
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Habilita mod_rewrite de Apache (Laravel lo necesita)
RUN a2enmod rewrite

# Copia el contenido del proyecto al contenedor
COPY . /var/www/html

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Da permisos correctos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala dependencias Laravel
RUN composer install --no-interaction --optimize-autoloader

# Expone el puerto
EXPOSE 80
