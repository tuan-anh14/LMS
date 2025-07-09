<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'id' => 1,
                'book_id' => 1,
                'name' => 'Triết học Mác Lê-nin',
                'has_tajweed_lectures' => 1,
                'has_upbringing_lectures' => 1,
                'created_at' => '2025-07-05 08:18:06',
                'updated_at' => '2025-07-09 15:06:45',
            ],
            [
                'id' => 2,
                'book_id' => 2,
                'name' => 'Giải tích',
                'has_tajweed_lectures' => 0,
                'has_upbringing_lectures' => 0,
                'created_at' => '2025-07-05 08:18:06',
                'updated_at' => '2025-07-09 15:07:30',
            ],
            [
                'id' => 5,
                'book_id' => 4,
                'name' => 'Kinh tế lượng',
                'has_tajweed_lectures' => 1,
                'has_upbringing_lectures' => 1,
                'created_at' => '2025-07-09 18:49:23',
                'updated_at' => '2025-07-09 18:49:23',
            ],
        ];

        foreach ($projects as $project) {
            \App\Models\Project::create($project);
        }

    }//end of run

}//end of seeder
