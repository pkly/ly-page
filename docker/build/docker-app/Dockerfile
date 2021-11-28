FROM ghcr.io/pkly/ly-page/lypage-docker-with-compose:latest

WORKDIR /app
COPY docker/build/docker-compose.yml /app/docker-compose.yml

CMD docker-compose pull && docker-compose -p lypage up