FROM php:7.4.8-fpm-buster
RUN apt-get update

RUN mkdir /custom-setup
COPY ./scripts /custom-setup
WORKDIR /custom-setup

RUN chmod +x *.sh

RUN ./install_packages.sh
RUN ./enable_php_ext.sh

RUN rm -Rf /custom-setup

WORKDIR /www/api