FROM php:8.4-fpm-alpine

# dependencies
RUN apk update
RUN apk add zlib-dev icu-dev g++ curl curl-dev freetype-dev \
    libxml2-dev autoconf imagemagick-dev build-base bash \
    file coreutils ncurses oniguruma-dev libzip-dev postgresql-dev linux-headers

# install generic extensions
RUN docker-php-ext-install mbstring
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install curl
RUN docker-php-ext-install sockets
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install opcache
RUN docker-php-ext-install pdo_mysql

# install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
CMD php-fpm
EXPOSE 9000