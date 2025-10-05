<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemImage;
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
            'condition' => 'Like new',
        ]);

        ItemImage::create([
            'item_id' => 1,
            'image_path' => 'images/vintage_lamp.png',
        ]);

        Item::create([
            'category_id' => 1,
            'user_id' => 2,
            'name' => 'Sony Walkman',
            'description' => 'Portable cassette player with excellent sound quality.',
            'price' => 115000.00,
            'condition' => 'Well used',
        ]);

        ItemImage::create([
            'item_id' => 2,
            'image_path' => 'images/walkman.jpg',
        ]);
    }
}
