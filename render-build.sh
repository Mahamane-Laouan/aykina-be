#!/usr/bin/env bash
set -o errexit

echo "🔧 Running Laravel post-deploy setup..."

composer dump-autoload --optimize
php artisan package:discover --ansi || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan migrate --force || true

echo "✅ Laravel setup finished!"
