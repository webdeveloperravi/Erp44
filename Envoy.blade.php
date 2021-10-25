@servers(['web' => ['gemlab.com','localhost']])

@task('clear-cache', ['on' => 'web'])
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
@endtask
