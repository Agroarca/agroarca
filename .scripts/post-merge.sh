#!/bin/sh

#composer install
#npm install

echo $(pwd)
export $(cat .env )
echo $APP_ENV

if [ "production" = "$APP_ENV" ]
then
    #npm run prod
    echo 'prod'
else
   # npm run dev-all
    echo 'local'
fi

#executar na raiz do projeto
#ln -s ../../.scripts/post-merge.sh .git/hooks/post-merge
