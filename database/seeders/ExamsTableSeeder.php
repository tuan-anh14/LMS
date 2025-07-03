<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Database\Seeder;

class ExamsTableSeeder extends Seeder
{
    public function run(): void
    {
        $exams = [
            ['name' => 'اختبار 1.1', 'project_id' => 1,],
            ['name' => 'اختبار 1.2', 'project_id' => 1,],
            ['name' => 'اختبار 1.3', 'project_id' => 1,],

            ['name' => 'اختبار 2.1', 'project_id' => 2,],
            ['name' => 'اختبار 2.2', 'project_id' => 2,],
            ['name' => 'اختبار 2.3', 'project_id' => 2,],
        ];

        foreach ($exams as $exam) {

            Exam::create($exam);

        }//end of for each

    }//end of run

}//end of seeder
