git pull
composer install --no-dev --optimize-autoloader --no-interaction
php artisan optimize
php artisan route:cache
php artisan migrate
php artisan db:seed
bower install --allow-root
composer dump-autoload

