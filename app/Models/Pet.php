<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'price',
        'age',
        'gender',
        'color',
        'weight',
        'vaccination_status',
        'is_featured',
        'is_active',
        'category_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'image_url'
    ];

    // Tự động tạo slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pet) {
            if (empty($pet->slug)) {
                $pet->slug = Str::slug($pet->name);
            }
        });

        static::updating(function ($pet) {
            if ($pet->isDirty('name')) {
                $pet->slug = Str::slug($pet->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Accessor cho image URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-pet.jpg'); // Ảnh mặc định
    }

    // Accessor cho vaccination status
    public function getVaccinationTextAttribute()
    {
        $statuses = [
            'fully' => 'Đã tiêm đầy đủ',
            'partial' => 'Đã tiêm một phần',
            'none' => 'Chưa tiêm'
        ];

        return $statuses[$this->vaccination_status] ?? 'Không xác định';
    }

    // Accessor cho gender
    public function getGenderTextAttribute()
    {
        return $this->gender == 'male' ? 'Đực' : 'Cái';
    }

    // Accessor cho formatted price
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.') . ' đ';
    }
}
