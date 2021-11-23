#!/bin/bash# Change access rights for the Laravel folders
# in order to make Laravel able to access
# cache and logs folder.

 chgrp -R 777 storage bootstrap/cache && \
    chown -R 777 storage bootstrap/cache && \
    chmod -R ug+rwx storage bootstrap/cache && \
    # setup permission
 chmod -R 777 storage
 mkdir -m 777 public/uploads

# Create log file for Laravel and give it write access
# www-data is a standard apache user that must have an
# access to the folder structure
touch storage/logs/laravel.log && chmod 777 storage/logs/laravel.log && php artisan key:generate
# php artisan migrate:fresh --seed  &&
crontab ' * * * * root php /code/artisan schedule:run >> /dev/null 2>&1 2>&1'
# crontab -l -u root; echo '* * * * * root echo "Hello world" >> /dev/stdout 2>&1'


