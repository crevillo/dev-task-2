FROM php:7.4

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install -y \
        libzip-dev \
        zlib1g-dev \
        zip \
  && docker-php-ext-install zip

COPY ./ /app

RUN cd /app && composer install

ENTRYPOINT ["/app/entrypoint.sh"]
