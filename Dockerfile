FROM php:8.1.11-fpm-alpine3.16

ENV ROOT_DIR="/usr/local/src/"

WORKDIR /usr/local/src/

COPY . .

RUN curl https://getcomposer.org/composer.phar > /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer \
    && /usr/local/bin/composer install

WORKDIR /usr/local/src/public/

EXPOSE 9000

CMD ["php-fpm"]
