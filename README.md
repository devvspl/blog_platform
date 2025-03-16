# Laravel 12 API with Sanctum Authentication & Caching

## 📌 Project Setup Guide

---

## 🛠️ Prerequisites

- PHP >= 8.1
- Composer
- MySQL Database
- Laravel 12 Installed
- Redis (Optional for Cache)

---

## 🛑 Step 1: Clone the Project

```bash
git clone https://github.com/your-repo/laravel-api.git
```

Navigate to the project folder:

```bash
cd laravel-api
```

---

## ✅ Step 2: Install Dependencies

```bash
composer install
```

---

## 🛠️ Step 3: Setup Environment File

Copy `.env.example` to `.env`

```bash
cp .env.example .env
```

Update the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_api
DB_USERNAME=root
DB_PASSWORD=password
```

Set the cache driver to database:

```env
CACHE_DRIVER=database
```

---

## 📂 Step 4: Generate Application Key

```bash
php artisan key:generate
```

---

## 🛑 Step 5: Run Migrations

```bash
php artisan migrate
```

Create the `cache` table for caching:

```bash
php artisan cache:table
php artisan migrate
```

---

## 🚀 Step 6: Seed Database (Optional)

```bash
php artisan db:seed
```

---

## 🔑 Step 7: Install Laravel Sanctum

```bash
composer require laravel/sanctum
```

Publish Sanctum config:

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

Migrate Sanctum tables:

```bash
php artisan migrate
```

Add Sanctum Middleware in `app/Http/Kernel.php`:

```php
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```

---

## 🛑 Step 8: Install Laravel CORS

```bash
composer require barryvdh/laravel-cors
```

Publish CORS configuration:

```bash
php artisan vendor:publish --tag="cors"
```

---

## ✅ Step 9: Run Laravel Server

```bash
php artisan serve
```

---

## 🌐 API Endpoints

### 🔐 Authentication Endpoints

| Method | Endpoint        | Description            |
|--------|----------------|--------------------|
| POST   | /api/register   | Register New User |
| POST   | /api/login      | Login User            |
| POST   | /api/logout     | Logout User           |

### 📝 Post Endpoints

| Method | Endpoint           | Description            |
|--------|-----------------|--------------------|
| GET    | /api/posts         | Fetch All Posts    |
| POST   | /api/posts         | Create New Post   |
| GET    | /api/posts/{slug} | Get Single Post   |
| PUT    | /api/posts/{slug} | Update Post         |
| DELETE | /api/posts/{slug} | Delete Post           |

### 📂 Category Endpoints

| Method | Endpoint           | Description             |
|--------|----------------|--------------------|
| GET    | /api/categories | Get All Categories |

---

## 🛑 Caching Implementation

### ✅ For Posts Endpoint (10 Min Cache TTL)

```php
$posts = cache()->remember('posts_page_' . request('page', 1), now()->addMinutes(10), function () {
    return Post::with(['category', 'tags', 'user'])->where('status', 'published')->paginate(10);
});
```

### ✅ For Category Endpoint (10 Min Cache TTL)

```php
$categories = cache()->remember('categories_list', now()->addMinutes(10), function () {
    return Category::all();
});
```

---

## 🎯 Clear Cache Manually

```bash
php artisan cache:clear
```

---

## 🔥 API Testing (Postman or Insomnia)

### Register New User

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

### Login User

```json
{
    "email": "john@example.com",
    "password": "password"
}
```

Copy the token from response and use it in `Authorization: Bearer <token>` header for protected routes.

---

## 🛑 Run Tests

```bash
php artisan test
```

---

## ✅ Deployment Guide (Optional)

- Deploy to Heroku, DigitalOcean, or VPS
- Setup MySQL and Redis
- Configure `.env` file
- Run migrations & caching

---

## 🎉 Project Successfully Setup!

