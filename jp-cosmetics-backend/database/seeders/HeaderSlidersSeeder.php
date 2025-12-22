<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeaderSlidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         HeaderSlider::insert([
            [
                'label' => 'new_arrivals',
                'title' => 'Check Out Our Latest Products',
                'short_description' => 'Discover the newest items in our store.',
                'url' => '/products/new',
                'image' => 'header_sliders/new_arrivals.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'label' => 'discount',
                'title' => 'Flat 50% Off',
                'short_description' => 'Grab the best deals now!',
                'url' => '/discounts',
                'image' => 'header_sliders/flat_discount.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
