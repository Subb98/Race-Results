FROM php:8.1.11-fpm-alpine3.16

ENV ROOT_DIR="/usr/local/src/"
ENV APP_ENV="development"
ENV USER=docker
ENV UID=1000

WORKDIR /usr/local/src/public/

EXPOSE 9000

CMD ["php-fpm"]

RUN curl https://getcomposer.org/composer.phar > /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer

RUN adduser \
    --disabled-password \
    --gecos "" \
    --no-create-home \
    --uid "$UID" \
    "$USER"

USER "$USER"
