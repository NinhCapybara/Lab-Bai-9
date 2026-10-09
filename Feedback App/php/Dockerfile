FROM php:7.4-fpm

RUN sed -i \
        -e 's|http://deb.debian.org/debian-security|http://archive.debian.org/debian-security|g' \
        -e 's|http://deb.debian.org/debian|http://archive.debian.org/debian|g' \
        -e '/bullseye-updates/d' \
        /etc/apt/sources.list \
    && echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid \
    && apt-get update \
    && apt-get install -y --no-install-recommends iputils-ping \
    && docker-php-ext-install mysqli \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

RUN echo "clear_env = no" >> /usr/local/etc/php-fpm.d/www.conf
