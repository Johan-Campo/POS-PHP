FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libwebp-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . .

RUN mkdir -p app/views/fotos app/views/productos \
    && chmod -R 777 app/views/fotos app/views/productos

EXPOSE 10000

CMD ["php", "-S", "0.0.0.0:10000", "router.php"]
