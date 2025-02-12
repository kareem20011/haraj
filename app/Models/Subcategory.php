<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Subcategory extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['category_id', 'name_ar', 'name_en'];

    // Define the relationship with main category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Define the relationship with products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
