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
                'title' => 'مشروع 1',
                'short_description' => 'هذا النص مثال لنص اخر يمكن استبداله',
                'description' => 'هذا النص مثال لنص اخر يمكن استبداله',
                'image' => 'course1.jpg',
            ],
            [
                'title' => 'مشروع 2',
                'short_description' => 'هذا النص مثال لنص اخر يمكن استبداله',
                'description' => 'هذا النص مثال لنص اخر يمكن استبداله',
                'image' => 'course2.jpg',
            ],
            [
                'title' => 'مشروع 3',
                'short_description' => 'هذا النص مثال لنص اخر يمكن استبداله',
                'description' => 'هذا النص مثال لنص اخر يمكن استبداله',
                'image' => 'course3.jpg',
            ],

        ];

        foreach ($courses as $course) {

            Course::create($course);

        }//end of foreach

    }//end of run

}//end of seeder
