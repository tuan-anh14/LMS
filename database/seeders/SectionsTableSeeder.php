<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'id' => 1,
                'center_id' => 1,
                'project_id' => 1,
                'course_id' => 0,
                'name' => 'K1-TRIET-01',
                'created_at' => '2025-07-05 08:18:06',
                'updated_at' => '2025-07-09 15:10:29',
            ],
            [
                'id' => 2,
                'center_id' => 1,
                'project_id' => 2,
                'course_id' => 0,
                'name' => 'K1-GT-01',
                'created_at' => '2025-07-05 08:18:06',
                'updated_at' => '2025-07-09 15:10:44',
            ],
            [
                'id' => 4,
                'center_id' => 2,
                'project_id' => 1,
                'course_id' => 0,
                'name' => 'K2-TRIET-01',
                'created_at' => '2025-07-05 08:18:06',
                'updated_at' => '2025-07-09 15:11:07',
            ],
            [
                'id' => 5,
                'center_id' => 2,
                'project_id' => 2,
                'course_id' => 0,
                'name' => 'K2-GT-01',
                'created_at' => '2025-07-05 08:18:06',
                'updated_at' => '2025-07-09 15:11:19',
            ],
        ];

        foreach ($sections as $section) {
            \App\Models\Section::create($section);
        }

    }//end of run

}//end of seeder
