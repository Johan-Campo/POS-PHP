FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libwebp-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY apache.conf /etc/apache2/sites-available/000-default.conf

RUN sed -i 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/' /etc/apache2/sites-available/000-default.conf

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

RUN mkdir -p /var/www/html/app/views/fotos \
    && mkdir -p /var/www/html/app/views/productos \
    && chown -R www-data:www-data /var/www/html/app/views/fotos \
    && chown -R www-data:www-data /var/www/html/app/views/productos

EXPOSE 10000
