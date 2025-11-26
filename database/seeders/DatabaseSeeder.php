<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pet;
use App\Models\PetImage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo user admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@petstore.com',
            'password' => bcrypt('password'),
        ]);

        // Tạo 5 user thường
        User::factory(5)->create();

        // Tạo categories
        $categories = Category::factory()->createMany([
            ['name' => 'Chó', 'slug' => 'cho'],
            ['name' => 'Mèo', 'slug' => 'meo'],
            ['name' => 'Chim', 'slug' => 'chim'],
            ['name' => 'Cá', 'slug' => 'ca'],
            ['name' => 'Thú Cưng Khác', 'slug' => 'thu-cung-khac'],
        ]);

        // Tạo pets với hình ảnh
        Pet::factory(30)->create()->each(function ($pet) {
            // Tạo 1-4 hình ảnh cho mỗi pet
            $imageCount = rand(1, 4);
            
            PetImage::factory($imageCount)->create([
                'pet_id' => $pet->id,
            ]);

            // Đặt 1 hình làm hình chính
            $pet->images()->first()->update(['is_main' => true]);
        });

        // Tạo một số pet featured
        Pet::factory(5)->featured()->create()->each(function ($pet) {
            PetImage::factory(3)->create([
                'pet_id' => $pet->id,
            ]);
            $pet->images()->first()->update(['is_main' => true]);
        });

        // Tạo một số pet đang sale
        Pet::factory(8)->onSale()->create()->each(function ($pet) {
            PetImage::factory(2)->create([
                'pet_id' => $pet->id,
            ]);
            $pet->images()->first()->update(['is_main' => true]);
        });
    }
}
