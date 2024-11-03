FROM php:8.3.0-fpm-alpine

RUN apk add --no-cache \
    linux-headers \
    curl \
    git \
    bash \
    libxml2-dev

RUN apk add --no-cache postgresql-dev && docker-php-ext-install pdo_pgsql

ENV TZ=Asia/Almaty

RUN apk add --no-cache tzdata \
    && cp /usr/share/zoneinfo/Asia/Almaty /etc/localtime \
    && echo "Asia/Almaty" > /etc/timezone \
    && apk del tzdata

COPY ./../ /var/www
WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./php.ini /usr/local/etc/php/php.ini

COPY ./crontab /etc/crontabs/root

RUN chmod 0644 /etc/crontabs/root

CMD ["sh", "-c", "crond && php-fpm"]

EXPOSE 9000
