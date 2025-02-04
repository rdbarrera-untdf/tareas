FROM php:8.1-apache

# Instalar extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && docker-php-ext-enable pdo_pgsql

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar los archivos de la aplicación
COPY ./html /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
