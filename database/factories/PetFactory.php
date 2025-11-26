<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    protected $model = Pet::class;

    public function definition(): array
    {
        // Danh sách giống chó phổ biến
        $dogBreeds = [
            'Poodle', 'Chihuahua', 'Golden Retriever', 'Bulldog', 'Beagle',
            'German Shepherd', 'Siberian Husky', 'Pug', 'Shih Tzu', 'Corgi',
            'Dachshund', 'Boxer', 'Rottweiler', 'Doberman', 'Labrador'
        ];

        // Danh sách giống mèo phổ biến
        $catBreeds = [
            'Persian', 'Siamese', 'Maine Coon', 'Bengal', 'Ragdoll',
            'British Shorthair', 'Scottish Fold', 'Sphynx', 'Russian Blue', 'Abyssinian'
        ];

        // Danh sách màu sắc
        $colors = ['Trắng', 'Đen', 'Nâu', 'Vàng', 'Xám', 'Kem', 'Socola', 'Tam thể', 'Xám xanh'];

        // Chọn ngẫu nhiên giống loài
        $breeds = array_merge($dogBreeds, $catBreeds);
        $breed = $this->faker->randomElement($breeds);

        // Tạo tên dựa trên giống
        $name = $breed . ' ' . $this->faker->firstName();

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->numberBetween(1000000, 50000000), // 1tr - 50tr
            'sale_price' => $this->faker->optional(0.3)->numberBetween(500000, 25000000), // 30% có sale
            'stock' => $this->faker->numberBetween(1, 10),
            'breed' => $breed,
            'age' => $this->faker->numberBetween(2, 36), // 2-36 tháng
            'gender' => $this->faker->randomElement(['male', 'female']),
            'color' => $this->faker->randomElement($colors),
            'weight' => $this->faker->randomFloat(2, 1, 30), // 1-30 kg
            'vaccination_status' => $this->faker->randomElement(['Đã tiêm đủ', 'Đã tiêm cơ bản', 'Chưa tiêm']),
            'health_notes' => $this->faker->optional(0.7)->sentence(), // 70% có ghi chú sức khỏe
            'is_featured' => $this->faker->boolean(20), // 20% là featured
            'is_active' => true,
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }

    // State methods cho các trường hợp đặc biệt
    public function featured(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_featured' => true,
            ];
        });
    }

    public function onSale(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'sale_price' => $attributes['price'] * 0.8, // Giảm 20%
            ];
        });
    }

    public function outOfStock(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'stock' => 0,
            ];
        });
    }

    public function forDogs(): Factory
    {
        $dogBreeds = [
            'Poodle', 'Chihuahua', 'Golden Retriever', 'Bulldog', 'Beagle',
            'German Shepherd', 'Siberian Husky', 'Pug', 'Shih Tzu', 'Corgi'
        ];

        return $this->state(function (array $attributes) use ($dogBreeds) {
            $breed = $this->faker->randomElement($dogBreeds);
            return [
                'name' => $breed . ' ' . $this->faker->firstName(),
                'breed' => $breed,
            ];
        });
    }

    public function forCats(): Factory
    {
        $catBreeds = [
            'Persian', 'Siamese', 'Maine Coon', 'Bengal', 'Ragdoll',
            'British Shorthair', 'Scottish Fold', 'Sphynx'
        ];

        return $this->state(function (array $attributes) use ($catBreeds) {
            $breed = $this->faker->randomElement($catBreeds);
            return [
                'name' => $breed . ' ' . $this->faker->firstName(),
                'breed' => $breed,
            ];
        });
    }
}
