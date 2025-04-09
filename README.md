# Laravel 12 Blog Platform – Setup Guide

A Laravel 12-based blog platform powered by Sanctum, Livewire, and Flux.

---

## 📋 Prerequisites

Make sure the following are installed on your system:

- PHP >= 8.1  
- Composer  
- MySQL  
- Node.js & NPM  
- Laravel 12  

---

## 🚀 Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/devvspl/blog_platform.git
cd blog_platform
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Setup Environment

Copy the example environment file:

```bash
cp .env.example .env
```

Update `.env` with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_platform
DB_USERNAME=root
DB_PASSWORD=root
```

Set cache driver to use the database:

```env
CACHE_DRIVER=database
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations

Run all migrations:

```bash
php artisan migrate
```

Create the cache table:

```bash
php artisan cache:table
php artisan migrate
```

### 6. Seed the Database

```bash
php artisan db:seed
```

### 7. Install Laravel Sanctum

```bash
composer require laravel/sanctum
```

Publish Sanctum configuration and run migrations:

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

Add Sanctum middleware to `app/Http/Kernel.php` under the `api` group:

```php
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```

### 8. Install and Build Frontend Dependencies

Install frontend packages:

```bash
npm install
```

Build assets for production:

```bash
npm run build
```

Or run in development mode:

```bash
npm run dev
```

### 9. Install Livewire and Flux

```bash
composer require livewire/livewire
composer require livewire/flux
```

Publish Livewire config:

```bash
php artisan livewire:publish
```

### 10. Start Laravel Development Server

```bash
php artisan serve
```

---

## 📡 API Documentation

You can find detailed API documentation on Postman:  
[📄 Postman API Docs](https://documenter.getpostman.com/view/36783049/2sAYkBt26x)

---

## ♻️ Clearing Cache

```bash
php artisan cache:clear
```

---

## 🛠️ Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

