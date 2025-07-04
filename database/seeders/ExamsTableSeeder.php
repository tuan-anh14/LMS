<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Database\Seeder;

class ExamsTableSeeder extends Seeder
{
    public function run(): void
    {
        $exams = [
            ['name' => 'Bài kiểm tra 1.1', 'project_id' => 1,],
            ['name' => 'Bài kiểm tra 1.2', 'project_id' => 1,],
            ['name' => 'Bài kiểm tra 1.3', 'project_id' => 1,],

            ['name' => 'Bài kiểm tra 2.1', 'project_id' => 2,],
            ['name' => 'Bài kiểm tra 2.2', 'project_id' => 2,],
            ['name' => 'Bài kiểm tra 2.3', 'project_id' => 2,],
        ];

        foreach ($exams as $exam) {

            Exam::create($exam);

        }//end of for each

    }//end of run

}//end of seeder
