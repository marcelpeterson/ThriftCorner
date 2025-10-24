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
            'image_path' => 'images/vintage_lamp.jpg',
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

        Item::create([
            'category_id' => 2,
            'user_id' => 3,
            'name' => 'Office Chair',
            'description' => 'Ergonomic office chair with adjustable height.',
            'price' => 550000.00,
            'condition' => 'Like new',
        ]);

        ItemImage::create([
            'item_id' => 3,
            'image_path' => 'images/office_chair.jpg',
        ]);

        Item::create([
            'category_id' => 2,
            'user_id' => 3,
            'name' => 'Office Table',
            'description' => 'A sturdy office table with ample workspace.',
            'price' => 850000.00,
            'condition' => 'Lightly used',
        ]);

        ItemImage::create([
            'item_id' => 4,
            'image_path' => 'images/office_table.jpg',
        ]);

        Item::create([
            'category_id' => 3,
            'user_id' => 4,
            'name' => 'Neck Fan',
            'description' => 'A portable neck fan for personal cooling.',
            'price' => 150000.00,
            'condition' => 'Lightly used',
        ]);

        ItemImage::create([
            'item_id' => 5,
            'image_path' => 'images/neck_fan.jpg',
        ]);

        Item::create([
            'category_id' => 3,
            'user_id' => 4,
            'name' => 'Bottle',
            'description' => 'A reusable water bottle made from stainless steel.',
            'price' => 110000.00,
            'condition' => 'Brand new',
        ]);

        ItemImage::create([
            'item_id' => 6,
            'image_path' => 'images/bottle.jpg',
        ]);

        Item::create([
            'category_id' => 4,
            'user_id' => 1,
            'name' => 'Cupboard',
            'description' => 'A classic wooden cupboard with ample storage space.',
            'price' => 90000.00,
            'condition' => 'Well used',
        ]);

        ItemImage::create([
            'item_id' => 7,
            'image_path' => 'images/cupboard.jpg',
        ]);

        Item::create([
            'category_id' => 4,
            'user_id' => 1,
            'name' => 'Utensil Set',
            'description' => 'A complete set of kitchen utensils.',
            'price' => 50000.00,
            'condition' => 'Brand new',
        ]);

        ItemImage::create([
            'item_id' => 8,
            'image_path' => 'images/utensil.jpg',
        ]);
    }
}
