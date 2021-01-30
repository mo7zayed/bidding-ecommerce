# Laravel & Nuxt Ecommerce.
    this is a simple laravel & nuxt ecommerce app i'm using jwt for token generation and bulma as css framework.
## Install on your machine.

### Backend
    - `composer install`
    - `cp .env.example .env` then fill your data.
    - run `php artisan jwt:secret` to generate a secret token.
    - run `php artisan migrate --seed` to generate a dummy data.
    - run `php artisan serve` to serve the project.
    - if you are going to run a tests you have to create a mysql database for that and put its cerdentials in phpunit.xml
### Client
    - go to the backend base path then `cd client`
    - `npm install` to install npm packages.
    - `npm run dev` for development environment
