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
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create 2 Author Users
        User::create([
            'name' => 'Author One',
            'email' => 'author1@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'author',
        ]);

        User::create([
            'name' => 'Author Two',
            'email' => 'author2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'author',
        ]);

        // Create 5 Categories
        $categories = [];
        for ($i = 1; $i <= 5; $i++) {
            $name = 'Category ' . $i;
            $categories[] = Category::create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)), // Generate slug
            ]);
        }


        // Create 10 Posts and attach them to random categories
        $posts = [];
        foreach (range(1, 10) as $i) {
            $title = 'Post Title ' . $i;
            $posts[] = Post::create([
                'title' => $title,
                'slug' => strtolower(str_replace(' ', '-', $title)), // Generate slug
                'content' => 'This is the content of post ' . $i,
                'category_id' => $categories[array_rand($categories)]->id,
                'user_id' => rand(1, 3),
            ]);
        }


        // Create 15 Tags
        $tags = [];
        for ($i = 1; $i <= 15; $i++) {
            $tagName = 'Tag ' . $i;
            $tags[] = Tag::create([
                'name' => $tagName,
                'slug' => strtolower(str_replace(' ', '-', $tagName)), // Generate slug
            ]);
        }

        // Attach tags to posts
        foreach ($posts as $post) {
            $post->tags()->attach(
                collect($tags)->random(rand(1, 5))->pluck('id')->toArray()
            );
        }
    }
}
