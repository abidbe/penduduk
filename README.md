<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel Project - Installation Guide

## Requirements

-   PHP >= 8.1
-   Composer
-   Node.js & npm
-   MySQL/PostgreSQL

## Installation

1. **Clone repository**

    ```bash
    git clone <repository-url>
    cd test-jmc
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Environment setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Database configuration**

    Edit `.env` file:

    ```env
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

5. **Run migrations**

    ```bash
    php artisan migrate
    ```

6. **Build assets**

    ```bash
    npm run dev
    ```

7. **Start server**
    ```bash
    php artisan serve
    ```

Visit: http://127.0.0.1:8000

## Additional Commands

-   Clear cache: `php artisan cache:clear`
-   Storage link: `php artisan storage:link` (if needed)
-   Run tests: `php artisan
