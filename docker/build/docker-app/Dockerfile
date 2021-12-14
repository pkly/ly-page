FROM ghcr.io/pkly/ly-page/lypage-php-fpm:latest

RUN apk update && apk add nginx bash postgresql14

WORKDIR /var/www

COPY . /var/www
RUN rm -rf /var/www/docker

# setup environment for symfony
ENV MASCOT_PATH '%kernel.project_path%/empty'
ENV ADDITIONAL_TEMPLATE_PATH '%kernel.project_path%/empty'
ENV APP_ENV prod

ENV POSTGRES_PASSWORD postgres
ENV POSTGRES_USER postgres
ENV POSTGRES_DB lypage

ENV DATABASE_URL postgresql://postgres:postgres@localhost/lypage?serverVersion=14.1&charset=utf8

# setup nginx
COPY docker/build/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY docker/dev/nginx/sites/sites.conf /etc/nginx/sites-available/sites.conf
COPY docker/dev/nginx/dev.conf /etc/nginx/nginx.conf

COPY docker/build/docker-app/docker-entrypoint.sh /var/www/entrypoint.sh
COPY docker/build/docker-app/postgres.sh /var/www/postgres.sh
RUN chmod +x /var/www/entrypoint.sh && chmod +x /var/www/postgres.sh

# PostgreSQL based on https://github.com/docker-library/postgres

RUN set -eux; \
	mkdir -p /var/lib/postgresql; \
	chown -R postgres:postgres /var/lib/postgresql

RUN mkdir /docker-entrypoint-initdb.d

COPY --from=postgres:14.1-alpine /usr/local/share/postgresql/postgresql.conf.sample /usr/local/share/postgresql/postgresql.conf.sample

# make the sample config easier to munge (and "correct by default")
RUN set -eux; \
	cp -v /usr/local/share/postgresql/postgresql.conf.sample /usr/local/share/postgresql/postgresql.conf.sample.orig; \
	sed -ri "s!^#?(listen_addresses)\s*=\s*\S+.*!\1 = '*'!" /usr/local/share/postgresql/postgresql.conf.sample; \
	grep -F "listen_addresses = '*'" /usr/local/share/postgresql/postgresql.conf.sample

RUN mkdir -p /var/run/postgresql && chown -R postgres:postgres /var/run/postgresql && chmod 2777 /var/run/postgresql

ENV PGDATA /var/lib/postgresql/data
# this 777 will be replaced by 700 at runtime (allows semi-arbitrary "--user" values)
RUN mkdir -p "$PGDATA" && chown -R postgres:postgres "$PGDATA" && chmod 777 "$PGDATA"
VOLUME /var/lib/postgresql/data

STOPSIGNAL SIGINT

EXPOSE 5432
EXPOSE 80
ENTRYPOINT /var/www/entrypoint.sh
