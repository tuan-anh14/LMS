<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Seeder;

class SlidesTableSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'upper_title' => 'ويبسايتي',
                'title' => 'ويبسايتي',
                'image' => 'slide1.jpg',
                'link' => '#',
            ],
            [
                'upper_title' => 'ويبسايتي',
                'title' => 'ويبسايتي',
                'image' => 'slide2.jpg',
                'link' => '#',
            ],


        ];

        foreach ($slides as $slide) {

            Slide::create($slide);

        }//end of foreach

    }//end of run

}//end of seeder
