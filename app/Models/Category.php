<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name_ar', 'name_en'];

    // Subcategories relation
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, Subcategory::class);
    }

    // Method to get subcategory data with localized name
    public function getSubcategoriesWithLocalizedName()
    {
        $locale = session('locale', 'en'); // Retrieve the current locale

        return $this->subcategories->map(function ($subcategory) use ($locale) {
            return [
                'id' => $subcategory->id,
                'name' => $locale === 'ar' ? $subcategory->name_ar : $subcategory->name_en,
            ];
        })->toArray(); // Convert the collection to an array
    }
}
