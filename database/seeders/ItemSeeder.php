<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::create([
            'category_id' => 1,
            'user_id' => 1,
            'name' => 'Vintage Lamp',
            'description' => 'A beautiful vintage lamp in excellent condition.',
            'price' => 45000.00,
            'photo_url' => 'storage/images/vintage_lamp.png',
            'condition' => 'Like new',
        ]);
    }
}
