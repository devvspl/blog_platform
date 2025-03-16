<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'category_id', 'user_id'];

    // Relation with Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relation with Tags
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    // Relation with User (Author)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
