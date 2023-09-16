ARG PHP_VERSION=8.2

FROM php:${PHP_VERSION}-fpm-bullseye
RUN apt-get update

RUN mkdir /custom-setup
COPY ./scripts /custom-setup
WORKDIR /custom-setup

RUN chmod +x *.sh

RUN ./install_packages.sh \
    && ./enable_php_ext.sh \
    && ./install_composer.sh

RUN rm -rf /custom-setup

WORKDIR /www/api
