FROM ghcr.io/pkly/ly-page/lypage-php-fpm:latest

COPY . /var/www

RUN rm -rf /var/www/docker

WORKDIR /var/www
CMD php-fpm
EXPOSE 9000