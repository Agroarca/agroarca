#!/bin/sh

composer install
npm install
npm run prod

#ln -s $(pwd)/.scripts/post-merge.sh .git/hooks/post-merge
