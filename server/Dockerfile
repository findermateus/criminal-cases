FROM php:8.3-apache AS base
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    libpq-dev \
    libzip-dev zip && \
    docker-php-ext-install pdo pdo_pgsql zip bcmath && \
    docker-php-ext-enable pdo_pgsql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

COPY containerConfig/apache2.conf "$APACHE_CONFDIR/conf-enabled/apache2.conf"
COPY containerConfig/xdebug.ini "$PHP_INI_DIR/conf.d/xdebug.ini"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY containerConfig/apache2.conf "$APACHE_CONFDIR/conf-enabled/apache2.conf"