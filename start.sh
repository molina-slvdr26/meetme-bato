#!/bin/sh
set -e

touch /app/database/database.sqlite

php artisan package:discover --ansi
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache || true

exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
