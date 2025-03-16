# Laravel 12 Blog Platform API

## 📌 Project Setup Guide

---

## 🛠️ Prerequisites

- PHP >= 8.1
- Composer
- MySQL Database
- Laravel 12 Installed

---

## 🛑 Step 1: Clone the Project

```bash
git clone https://github.com/devvspl/blog_platform.git
```

Navigate to the project folder:

```bash
cd blog_platform
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
DB_DATABASE=blog_platform
DB_USERNAME=root
DB_PASSWORD=root
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

## ✅ Step 9: Run Laravel Server

```bash
php artisan serve
```

---

## 🌐 API Endpoints Documentation

### 🔐 Authentication Endpoints

#### 1️⃣ Register New User
- **Method:** POST
- **Endpoint:** `/api/register`
- **Description:** Register a new user with name, email, and password.
- **Request Body:**
```json
{
  "name": "dev",
  "email": "dev@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```
- **Response:**
```json
{
  "status": true,
  "message": "User registered successfully",
  "data": {
    "user": {},
    "token": "<API_TOKEN>"
  }
}
```

#### 2️⃣ Login User
- **Method:** POST
- **Endpoint:** `/api/login`
- **Description:** Authenticate user with email and password.
- **Request Body:**
```json
{
  "email": "dev@example.com",
  "password": "password123"
}
```
- **Response:**
```json
{
  "status": true,
  "message": "Login successful",
  "data": {
    "user": {},
    "token": "<API_TOKEN>"
  }
}
```

#### 3️⃣ Logout User
- **Method:** POST
- **Endpoint:** `/api/logout`
- **Description:** Logout the authenticated user and revoke the token.
- **Response:**
```json
{
  "status": true,
  "message": "Logout successful"
}
```

---

### 📝 Post Endpoints

#### 4️⃣ Fetch All Posts
- **Method:** GET
- **Endpoint:** `/api/posts`
- **Description:** Retrieve all posts with pagination.
- **Response:**
```json
{
  "status": true,
  "message": "Posts fetched successfully",
  "data": []
}
```

#### 5️⃣ Create New Post
- **Method:** POST
- **Endpoint:** `/api/posts`
- **Description:** Create a new post with title, content, category, and tags.
- **Request Body:**
```json
{
  "title": "My First Post",
  "content": "This is the content of my first post",
  "category_id": 1,
  "tags": [1, 2, 3]
}
```
- **Response:**
```json
{
  "status": true,
  "message": "Post created successfully",
  "data": {}
}
```

#### 6️⃣ Get Single Post
- **Method:** GET
- **Endpoint:** `/api/posts/{slug}`
- **Description:** Fetch a specific post by slug.
- **Response:**
```json
{
  "status": true,
  "message": "Post fetched successfully",
  "data": {}
}
```

#### 7️⃣ Update Post
- **Method:** PUT
- **Endpoint:** `/api/posts/{slug}`
- **Description:** Update a post's title, content, category, and tags.
- **Request Body:**
```json
{
  "title": "Updated Post Title",
  "content": "Updated content",
  "category_id": 2,
  "tags": [2, 4]
}
```
- **Response:**
```json
{
  "status": true,
  "message": "Post updated successfully",
  "data": {}
}
```

#### 8️⃣ Delete Post
- **Method:** DELETE
- **Endpoint:** `/api/posts/{slug}`
- **Description:** Delete a post by slug.
- **Response:**
```json
{
  "status": true,
  "message": "Post deleted successfully"
}
```

---

### 📂 Category Endpoints

#### 9️⃣ Get All Categories
- **Method:** GET
- **Endpoint:** `/api/categories`
- **Description:** Fetch all categories.
- **Response:**
```json
{
  "status": true,
  "message": "Category list fetched successfully",
  "data": []
}
```

---

### 🔍 Search Endpoint

#### 🔎 Search Posts
- **Method:** GET
- **Endpoint:** `/api/search`
- **Description:** Search posts by keyword, category, or tag.
- **Query Parameters:**
```json
{
  "keyword": "My First Post",
  "category": "technology",
  "tag": "laravel"
}
```
- **Response:**
```json
{
  "status": true,
  "message": "Posts filtered successfully",
  "data": []
}
```
🔗 **Refer Postman API Documentation:** [Click Here](https://documenter.getpostman.com/view/36783049/2sAYkBt26x)
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

