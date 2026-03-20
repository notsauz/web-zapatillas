# Base image with PHP FPM
FROM php:8.2-fpm

# Instala dependencias del sistema y extensiones PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libzip-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copia dependencias y ejecuta composer (instala paquetes PHP)
COPY composer.json composer.lock* ./
RUN composer install --prefer-dist --no-interaction --no-progress --no-scripts

# Copia el código y genera autoload optimizado
COPY . .
RUN composer dump-autoload --optimize

# Ajuste de permisos para evitar errores de escritura en storage y cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expone el puerto PHP-FPM
EXPOSE 9000