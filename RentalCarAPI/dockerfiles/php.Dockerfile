FROM php:8.3-fpm-alpine

WORKDIR /var/www/rentalcarapi/

RUN apk update && \
    apk add --no-cache postgresql-dev && \
    docker-php-ext-install pgsql