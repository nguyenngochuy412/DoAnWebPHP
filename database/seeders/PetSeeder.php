<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\PetImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 20 pets cơ bản
        $pets = Pet::factory(20)->create();

        foreach ($pets as $pet) {
            // Tạo hình ảnh cho mỗi pet
            $images = PetImage::factory(rand(1, 3))->create([
                'pet_id' => $pet->id,
            ]);

            // Đặt hình đầu tiên làm hình chính
            $images->first()->update(['is_main' => true]);
        }

        // Tạo pets đặc biệt
        $featuredPets = Pet::factory(5)
            ->featured()
            ->onSale()
            ->create();

        foreach ($featuredPets as $pet) {
            PetImage::factory(4)->create([
                'pet_id' => $pet->id,
            ]);
            $pet->images()->first()->update(['is_main' => true]);
        }
    }
}
