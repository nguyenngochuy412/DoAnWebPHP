<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    // Danh sách categories cố định
    private $categories = [
        ['name' => 'Chó', 'slug' => 'cho'],
        ['name' => 'Mèo', 'slug' => 'meo'],
        ['name' => 'Chim', 'slug' => 'chim'],
        ['name' => 'Cá', 'slug' => 'ca'],
        ['name' => 'Thú Cưng Khác', 'slug' => 'thu-cung-khac'],
    ];

    private $index = 0;

    public function definition(): array
    {
        // Lấy category theo thứ tự
        if ($this->index >= count($this->categories)) {
            $this->index = 0;
        }

        $category = $this->categories[$this->index];
        $this->index++;

        return [
            'name' => $category['name'],
            'slug' => $category['slug'],
            'description' => $this->getCategoryDescription($category['name']),
            'image' => $this->getCategoryImage($category['name']),
            'is_active' => true,
        ];
    }

    private function getCategoryDescription(string $categoryName): string
    {
        $descriptions = [
            'Chó' => 'Các giống chó cảnh đẹp, thông minh và trung thành',
            'Mèo' => 'Các giống mèo cảnh đáng yêu, thanh lịch và độc lập',
            'Chim' => 'Các loài chim cảnh có tiếng hót hay và màu sắc đẹp',
            'Cá' => 'Các loài cá cảnh nhiều màu sắc cho bể cá của bạn',
            'Thú Cưng Khác' => 'Các loại thú cưng đặc biệt khác như thỏ, hamster, v.v.',
        ];

        return $descriptions[$categoryName];
    }

    private function getCategoryImage(string $categoryName): string
    {
        $images = [
            'Chó' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?w=400&h=300&fit=crop',
            'Mèo' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=400&h=300&fit=crop',
            'Chim' => 'https://images.unsplash.com/photo-1552728089-57bdde30beb3?w=400&h=300&fit=crop',
            'Cá' => 'https://images.unsplash.com/photo-1583235366115-9ef0b037461c?w=400&h=300&fit=crop',
            'Thú Cưng Khác' => 'https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308?w=400&h=300&fit=crop',
        ];

        return $images[$categoryName];
    }
}
