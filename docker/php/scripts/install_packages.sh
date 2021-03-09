#!/bin/sh

apt-get install -y --no-install-recommends \
    acl \
    bash \
    ca-certificates \
    cron \
    curl \
    imagemagick \
    git \
    gnupg \
    less \
    libmagickwand-dev \
    libmemcached-dev \
    libpq-dev \
    libpng-dev \
    libxml2-dev \
    libxslt1.1 \
    libxslt-dev \
    libzip-dev \
    unzip \
    wget \
    zlib1g-dev

rm -rf /var/lib/apt/lists/*

wget -O composer.phar https://getcomposer.org/composer-1.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer
