<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FooterSlidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FooterSlider::insert([
            [
                'label' => 'new_collection',
                'title' => 'Explore Our New Collection',
                'short_description' => 'Latest trends just for you.',
                'url' => '/collections/new',
                'image' => 'footer_sliders/new_collection.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'label' => 'trending',
                'title' => 'Trending Now',
                'short_description' => 'Our top trending products this week.',
                'url' => '/trending',
                'image' => 'footer_sliders/trending.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
