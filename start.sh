#!/bin/sh
set -e

echo "Waiting for MySQL at ${DB_HOST}:${DB_PORT}..."
for i in $(seq 1 60); do
  if nc -z "${DB_HOST}" "${DB_PORT:-3306}" 2>/dev/null; then
    echo "MySQL is up after ${i} attempts."
    break
  fi
  if [ "$i" -eq 60 ]; then
    echo "MySQL never became available. Exiting."
    exit 1
  fi
  sleep 3
done

sleep 3

php artisan package:discover --ansi
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache || true

exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
