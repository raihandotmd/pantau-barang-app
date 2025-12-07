#!/bin/sh
set -e

# Turn on maintenance mode
php artisan down || true

# Cache configuration, routes, and views
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Run migrations (be careful with this in production clusters, but fine for single instance)
php artisan migrate --force

# Turn off maintenance mode
php artisan up

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
