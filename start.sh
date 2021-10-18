#!/bin/sh
set -e
APP_CONTAINER="php"

printf "Starting....."
printf "\n"
echo "-----------------------------------------------------------------------------\n"

docker-compose build

printf "★ \e[33;1mStarting containers...\e[m\n\n"

docker-compose up --quiet-pull --remove-orphans --no-color -d

docker-compose exec $APP_CONTAINER sh -c "composer install"
docker-compose exec $APP_CONTAINER sh -c "composer run migrate"
#docker-compose exec $APP_CONTAINER sh -c "composer run seed"

printf "\n★ \e[33;1mReady: \e[34;1mhttp://127.0.0.1\e[m\n\n"
