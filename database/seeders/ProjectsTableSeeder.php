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
                'book_id' => 1,
                'name' => 'مشروع 1',
                'center_ids' => [1, 2],
                'has_tajweed_lectures' => 1,
                'has_upbringing_lectures' => 1,
            ],

            [
                'book_id' => 2,
                'name' => 'مشروع 2',
                'center_ids' => [1, 2],
            ],

            [
                'book_id' => 3,
                'name' => 'مشروع 3',
                'center_ids' => [1, 2],
            ],
        ];

        foreach ($projects as $project) {

            $newProject = Project::create(collect($project)->except('center_ids')->toArray());

            $newProject->centers()->sync($project['center_ids']);

        }//end of foreach

    }//end of run

}//end of seeder
