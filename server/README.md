# Laravel & Nuxt Ecommerce.
    this is a simple laravel & nuxt ecommerce app i'm using jwt for token generation and bulma as css framework.
## Install on your machine.

### Backend
    - `composer install`
    - `cp .env.example .env` then fill your data.
    - Define your time zone key `APP_TIMEZONE` in .env file.
    - run `php artisan jwt:secret` to generate a secret token.
    - run `php artisan migrate --seed` to generate a dummy data or import the database bidding_ecommerce.sql.
    - run `php artisan serve` to serve the project.
    - if you are going to run a tests you have to create a mysql database for that and put its cerdentials in phpunit.xml
