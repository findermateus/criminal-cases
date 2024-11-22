FROM php:8.2-apache AS base

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    libpq-dev \
    libzip-dev zip && \
    docker-php-ext-install pdo pdo_pgsql zip bcmath && \
    docker-php-ext-enable pdo_pgsql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

COPY ./apache2.conf "$APACHE_CONFDIR/conf-enabled/apache2.conf"