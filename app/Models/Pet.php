<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'sale_price', 'stock',
        'breed', 'age', 'gender', 'color', 'weight', 'vaccination_status',
        'health_notes', 'is_featured', 'is_active', 'category_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(PetImage::class);
    }

    public function getMainImageAttribute()
    {
        return $this->images->where('is_main', true)->first() ?? $this->images->first();
    }

    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
