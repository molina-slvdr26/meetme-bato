#!/bin/sh
set -e

echo "Waiting for MySQL port to open..."
until nc -z "${DB_HOST}" "${DB_PORT:-3306}"; do
  echo "MySQL not ready, retrying in 3s..."
  sleep 3
done
echo "MySQL port open. Waiting 5s for initialization..."
sleep 5

php artisan package:discover --ansi
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache || true

exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
