# Laravel 12 Blog Platform – Setup Guide  

## Prerequisites  

Before starting, ensure you have the following installed:  

- PHP >= 8.1  
- Composer  
- MySQL  
- Node.js & NPM  
- Laravel 12  

---

## Step 1: Clone the Project  

Clone the repository and navigate into the project folder:  

```bash
git clone https://github.com/devvspl/blog_platform.git
cd blog_platform
```

---

## Step 2: Install Dependencies  

Install PHP dependencies using Composer:  

```bash
composer install
```

---

## Step 3: Setup Environment  

Copy the example environment file:  

```bash
cp .env.example .env
```

Update the `.env` file with database credentials:  

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_platform
DB_USERNAME=root
DB_PASSWORD=root
```

Set the cache driver to use the database:  

```env
CACHE_DRIVER=database
```

---

## Step 4: Generate Application Key  

```bash
php artisan key:generate
```

---

## Step 5: Run Migrations  

Run database migrations:  

```bash
php artisan migrate
```

Create the `cache` table and migrate it:  

```bash
php artisan cache:table
php artisan migrate
```

---

## Step 6: Seed the Database  

```bash
php artisan db:seed
```

---

## Step 7: Install Laravel Sanctum  

```bash
composer require laravel/sanctum
```

Publish the Sanctum configuration file:  

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

Add Sanctum middleware in `app/Http/Kernel.php`:  

```php
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```

---

## Step 8: Install and Build Frontend Dependencies  

Install Node.js dependencies:  

```bash
npm install
```

Build assets for production:  

```bash
npm run build
```

For development mode:  

```bash
npm run dev
```

---

## Step 9: Install and Configure Livewire & Flux  

Livewire and Flux are used for real-time UI updates. Install them with:  

```bash
composer require livewire/livewire
composer require livewire/flux
```

Publish the Livewire configuration file:  

```bash
php artisan livewire:publish
```
---

## Step 10: Run Laravel Server  

```bash
php artisan serve
```

---

## API Documentation  

For API details, refer to the Postman documentation:  

[Postman API Documentation](https://documenter.getpostman.com/view/36783049/2sAYkBt26x)  

---

## Clearing Cache  

```bash
php artisan cache:clear
```

---
