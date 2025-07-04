<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Khóa học 1',
                'short_description' => 'Đây là mô tả ngắn cho khóa học 1',
                'description' => 'Đây là mô tả chi tiết cho khóa học 1',
                'image' => 'course1.jpg',
            ],
            [
                'title' => 'Khóa học 2',
                'short_description' => 'Đây là mô tả ngắn cho khóa học 2',
                'description' => 'Đây là mô tả chi tiết cho khóa học 2',
                'image' => 'course2.jpg',
            ],
            [
                'title' => 'Khóa học 3',
                'short_description' => 'Đây là mô tả ngắn cho khóa học 3',
                'description' => 'Đây là mô tả chi tiết cho khóa học 3',
                'image' => 'course3.jpg',
            ],

        ];

        foreach ($courses as $course) {

            Course::create($course);

        }//end of foreach

    }//end of run

}//end of seeder
