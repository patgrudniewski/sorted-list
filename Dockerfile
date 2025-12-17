FROM composer:2 AS build

WORKDIR /app

COPY ./composer.json /app/composer.json
COPY ./src /app/src

RUN composer install --ignore-platform-reqs --no-interaction --no-dev && rm -rf /app/composer.lock

FROM php:8.4-cli-alpine AS cli

COPY --from=build /app /app

WORKDIR /app
