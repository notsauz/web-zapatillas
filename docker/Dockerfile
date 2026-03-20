# docker/Dockerfile
FROM php:8.2-apache

# Instalar extensión para MySQL
RUN docker-php-ext-install pdo_mysql

# Activar rewrite
RUN a2enmod rewrite

# Configurar Apache para que use /var/www/html/public como raíz
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Crear directorio de trabajo
WORKDIR /var/www/html

# Dar permisos a las carpetas de Laravel (IMPORTANTE)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer puerto
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]