<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Prerequisites
- PHP 8.1+
- Composer
- npm

## Installation
- Clone this repository to your local machine
- `cp .env.example .env` to create a copy of the .env file
- `composer install` to install dependencies
- `php artisan key:generate` to generate an application key
- `php artisan migrate:fresh --seed` to create and seed the database
- `php artisan serve` to start the server
- `npm run dev` to start the frontend
- Login via http://localhost:8000/login
  - username: sales@coffee.shop
  - password: password

# Features
- Select a coffee, enter a quantity and unit cost to instantly see the selling price
- Click 'record sale' to save the sale to the database
