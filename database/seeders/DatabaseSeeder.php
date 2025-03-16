<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 1 Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create 2 Author Users
        User::factory()->count(2)->create(['role' => 'author']);

        // Create 5 Categories
        $categories = Category::factory()->count(5)->create();

        // Create 10 Posts and attach them to random categories
        $posts = Post::factory()->count(10)->create();

        // Create 15 Tags
        $tags = Tag::factory()->count(15)->create();

        // Attach tags to posts
        $posts->each(function ($post) use ($tags) {
            $post->tags()->attach(
                $tags->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
