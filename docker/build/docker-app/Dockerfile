FROM ghcr.io/pkly/ly-page/lypage-php-fpm:latest

RUN apk update && apk add nginx tini

WORKDIR /var/www

COPY . /var/www
RUN rm -rf /var/www/docker

# setup environment for symfony
ENV MASCOT_PATH '%kernel.project_path%/empty'
ENV ADDITIONAL_TEMPLATE_PATH '%kernel.project_path%/empty'
ENV APP_ENV prod

# setup nginx
COPY docker/build/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY docker/dev/nginx/sites/sites.conf /etc/nginx/sites-available/sites.conf
COPY docker/dev/nginx/dev.conf /etc/nginx/nginx.conf

COPY docker/build/docker-app/docker-entrypoint.sh /var/www/entrypoint.sh
RUN chmod +x /var/www/entrypoint.sh

ENTRYPOINT /var/www/entrypoint.sh
EXPOSE 80