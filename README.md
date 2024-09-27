<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# uPress Blog

A Laravel blog application that allows users to create posts, view external posts, and manage blog posts.

## Requirements

- PHP 8.0 or higher
- Composer
- npm
- MySQL
- Laravel 8.x or higher

NOTE: XAMPP can be used for local MySQL and PHP

## Installation
### 1. Clone the Repository
```
git init
git clone https://github.com/NivCohen01/uPressBlog.git
```
### 2. Install PHP and Laravel Dependencies
 * Download composer through [https://getcomposer.org/]
 * Run the following command to install the required PHP dependencies
```
composer install
```
### 3. Install NPM Dependencies
 * Download nodejs through [[https://getcomposer.org/](https://nodejs.org/en/download/package-manager)]
 * Run the following command to install the required Node.js dependencies:
```
npm install
```
### 4. Environment Setup
open `.env` file and configure the following settings:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

APP_URL=http://localhost:8000
```
**NOTE**: These settings are set for local run (eg XAMPP), if you run it on a server, change the settings appropriatly.

### 5. Generate Application Key
Run the following command to generate an application key:
```
php artisan key:generate
```

### 6. Setup Database
* Make sure you have MySQL running and pdo enabled.
* Run the migrations to create the required tables in the database:
  ```
  php artisan migrate
  ```

### 7. Enable PDO (if step 6 failed)
Ensure that PDO is enabled in your PHP setup. In your php.ini file, ensure the following lines are enabled (uncommented):
```
extension=pdo_mysql
extension=pdo
```
Return to step 6 (if it failed).

### 8. Start The Application
To start the application locally, run the following command:
```
php artisan serve
```
### 9. Compile Frontend Assets
To compile frontend assets, run the following command:
```
npm run watch
```

### Scheduling and Task Automation
his project also includes a console command to fetch external posts and save them to the local database.

To run the console command manually:
```
php artisan fetch:external-posts
```
## License

The project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
