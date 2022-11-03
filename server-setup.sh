#!/bin/bash
echo " ------ Installing libraries - composer install -- "
composer install


echo " ------ Migration script -- "
php artisan migrate


echo " ------ DB Seeder-- "
php artisan db:seed


echo " ------ DB Seeder-- "
php artisan jwt:secret

