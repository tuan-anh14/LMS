<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            ['center_id' => 1, 'project_id' => 1, 'name' => 'حلقه 1.1'],
            ['center_id' => 1, 'project_id' => 2, 'name' => 'حلقه 1.2'],
            ['center_id' => 1, 'project_id' => 3, 'name' => 'حلقه 1.3'],

            ['center_id' => 2, 'project_id' => 1, 'name' => 'حلقه 2.1'],
            ['center_id' => 2, 'project_id' => 2, 'name' => 'حلقه 2.2'],
            
        ];

        foreach ($sections as $section) {

            Section::create($section);

        }//end of for each

    }//end of run

}//end of seeder
