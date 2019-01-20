#!/usr/bin/env bash

sudo chmod +x ./tools/api/entrypoint.sh;
#docker network create g-network && docker-compose down && docker-compose up -d;
docker-compose down && docker-compose up -d;
docker exec -it api composer install;
docker exec -it api php bin/console doctrine:database:create;
docker-compose down;