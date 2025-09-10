#!/bin/sh

echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --force

# Cuối cùng chạy lệnh chính của container (PHP-FPM hoặc queue, v.v.)
exec "$@"
