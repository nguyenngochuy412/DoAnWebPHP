<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\PetImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PetImage>
 */
class PetImageFactory extends Factory
{
    protected $model = PetImage::class;

    public function definition(): array
    {
        // Danh sách hình ảnh thú cưng mẫu (có thể thay bằng URL thực tế)
        $petImages = [
            'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=400',
            'https://images.unsplash.com/photo-1552053831-71594a27632d?w=400',
            'https://hips.hearstapps.com/clv.h-cdn.co/assets/16/18/gettyimages-586890581.jpg?crop=0.668xw:1.00xh;0.219xw,0',
            'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=400',
            'https://images.unsplash.com/photo-1533738363-b7f9aef128ce?w=400',
            'https://images.unsplash.com/photo-1513360371669-4adf3dd7dff8?w=400',
            'https://www.alleycat.org/wp-content/uploads/2019/03/FELV-cat.jpg',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR2DB9O2ltVq4dxQovZOlOHGKtn_hOR2lcClg&s',
        ];

        return [
            'image_path' => $this->faker->randomElement($petImages),
            'is_main' => false,
            'pet_id' => Pet::factory(),
        ];
    }

    public function main(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_main' => true,
            ];
        });
    }
}
