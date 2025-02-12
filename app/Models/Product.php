<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['title', 'description', 'price', 'location', 'subcategory_id', 'user_id', 'status'];

    // category relation
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    // user creator
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // user how favore
    public function users()
    {
        return $this->belongsToMany(User::class, 'product_favorites', 'product_id', 'user_id');
    }
}
