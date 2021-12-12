FROM php:8.1-fpm-alpine3.15

# dependencies
RUN apk update
RUN apk add zlib-dev icu-dev g++ curl curl-dev freetype-dev \
    libxml2-dev autoconf imagemagick-dev build-base bash \
    file coreutils ncurses oniguruma-dev libzip-dev postgresql-dev

# install generic extensions
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install mbstring
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install curl
RUN docker-php-ext-install sockets
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install opcache

# install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY docker/build/php-fpm/ini/custom.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/dev/php/ini/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY docker/dev/php/conf/php-fpm-custom.conf /usr/local/etc/php-fpm.d/zz-php-fpm-custom.conf

WORKDIR /var/www
CMD php-fpm
EXPOSE 9000