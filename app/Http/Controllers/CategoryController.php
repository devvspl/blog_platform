<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Helpers\ResponseHelper;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryListRequest;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // List all categories
    public function index(CategoryListRequest $request)
    {
        try {
            $categories = cache()->remember('categories_list', now()->addMinutes(10), function () {
                return Category::all();
            });

            return ResponseHelper::success($categories, 'Category list fetched successfully');
        } catch (\Exception $e) {
            return ResponseHelper::error('Something went wrong while fetching categories', 500);
        }
    }

    // Create a new category
    public function store(CategoryRequest $request)
    {
        try {
            $category = Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ]);
            return ResponseHelper::success($category, 'Category created successfully', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('Something went wrong while creating the category', 500);
        }
    }
}
