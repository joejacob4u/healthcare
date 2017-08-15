composer install --no-dev --optimize-autoloader --no-interaction
composer dump-autoload
php artisan optimize
php artisan route:cache
php artisan migrate
bower install --allow-root
