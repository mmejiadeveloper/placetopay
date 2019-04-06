mkdir storage
cd storage
mkdir fonts
mkdir framework
cd framework
mkdir sessions
mkdir views
cd ../../

php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:clear
php artisan config:cache

composer dump-autoload
pause


