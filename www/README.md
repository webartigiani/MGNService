# MGNService - WebSite
    Based on template "Laravel Vue Admin LTE" https://github.com/AnowarCST/laravel-vue-crud-starter

## Tech Specification
- Laravel 8
- Vue 2 + VueRouter + vue-progressbar + sweetalert2 + laravel-vue-pagination
- Laravel Passport
- Admin LTE 3 + Bootstrap 4 + Font Awesome 5
- PHPUnit Test Case/Test Coverage

## Features
- Modal based Create+Edit, List with Pagination, Delete with Sweetalert
- Simple Static Dashboard
- Login, Forget+Reset Password as default auth
- Profile, Update Profile, Change Password, Avatar
- User Management

## Installation
- `composer install`
- Update `.env` and set your database credentials
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan passport:install`
- `npm install`
- `npm run dev`
- `php artisan serve`

## Requirements
    > laravel-masked-db-dump
        composer require beyondcode/laravel-masked-db-dump --ignore-platform-reqs

## Run
    '''
    cd www
    php artisan serve
    npm run watch
    '''

## Access
    user    info@webartigiani.it
    pwd     <il solito cammello>
    
## Ionic APP API
- get   api/app/workers/list/
- get   api/app/veichles/list/
- post  api/app/devices/add/

## Rsync
    '''
    cd www
    rsync -avPzh www/ <username>@mgnservice.it:/var/www/html/gestionale-mgn
    ssh <username>@mgnservice.it:/var/www/html/gestionale-mgn
    php artisan migrate
    '''

