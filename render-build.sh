#!/usr/bin/env bash
set -o errexit

# Optimisations Laravel après le déploiement
composer dump-autoload --optimize
php artisan package:discover --ansi
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
