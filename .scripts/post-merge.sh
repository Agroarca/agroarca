#!/bin/sh

#executar na raiz do projeto
#ln -s ../../.scripts/post-merge.sh .git/hooks/post-merge

echo "================================"
echo "| EXECUTANDO HOOK - POST MERGE |"
echo "================================"

php artisan down --refresh=5 --render="errors::503"

php artisan migrate

export $(cat .env )
echo "environment é $APP_ENV"

if [ "production" = "$APP_ENV" ]
then
    composer install --optimize-autoloader --no-dev
    php artisan migrate --force

    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

else
    composer install
    php artisan migrate
    npm install
    npm run dev-all
fi

php artisan up

