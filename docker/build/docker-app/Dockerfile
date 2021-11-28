FROM ghcr.io/pkly/ly-page/lypage-docker-with-compose:latest

WORKDIR /app
COPY docker/build/docker-compose.yml /app/docker-compose.yml

ENTRYPOINT docker-compose pull && docker volume rm lypage_shared_vol && docker-compose -p lypage_prod up