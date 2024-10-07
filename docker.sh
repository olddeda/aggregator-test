#!/bin/bash

cp .env.example .env
cp ./client/.env.example ./client/.env

composer install

./vendor/bin/sail build
./vendor/bin/sail up -d

echo "\n"
echo "Wait: Start docker..."

# TODO Need better solution
sleep 15

./vendor/bin/sail artisan migrate

./vendor/bin/sail restart

echo "\n"
echo "Wait: Restart docker..."

sleep 15

./vendor/bin/sail artisan news:source:parse

echo "\n\n"
echo "Web interface:"
echo "http://localhost:4000"
