## Setup Locally

1. run **composer install**
2. run **sail artisan migrate**
3. run **sail artisan passport:install**
4. update ENV to have CLIENT_ID and CLIENT_SECRET values based on the generated values in **oauth_clients** table

#### For Windows
1. run **composer install**
2. Install **Ubuntu 22 LTS** from the windows store
3. then open ubuntu and go to the source code
4. run **./vendor/bin/sail up -d**
5. run **sail artisan migrate**
6. run **sail artisan passport:install**
7. update ENV to have CLIENT_ID and CLIENT_SECRET values based on the generated values in **oauth_clients** table
8. run **./vendor/bin/sail artisan queue:work** for jobs and sending email


### Running artisan commands in sail
** ./vendor/bin/sail artisan <command>**
