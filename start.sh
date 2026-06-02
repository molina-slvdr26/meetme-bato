#!/bin/sh
set -e

echo "Waiting for MySQL to be ready..."
until mysqladmin ping -h"${DB_HOST}" -P"${DB_PORT:-3306}" -u"${DB_USERNAME}" -p"${DB_PASSWORD}" --silent 2>/dev/null; do
  sleep 3
done
echo "MySQL is ready."

php artisan package:discover --ansi
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
