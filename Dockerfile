# Usa una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala dependencias del sistema y extensiones necesarias de PHP
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpng-dev libonig-dev libxml2-dev zip nodejs npm \
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

# Instala dependencias de Laravel
RUN composer install --no-interaction --optimize-autoloader

# Genera clave de aplicación y cachea configuración
RUN php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan storage:link

# Si usas Vite o Laravel Mix, compila los assets
RUN npm install && npm run build

# Expone el puerto HTTP
EXPOSE 80
