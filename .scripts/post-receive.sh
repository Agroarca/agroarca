#!/bin/bash
TARGET="/var/www/agroarca"
GIT_DIR="/var/www/agroarca/.git"
BRANCH="main"
git --work-tree=$TARGET --git-dir=$GIT_DIR checkout -f
