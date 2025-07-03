<?php

namespace Database\Seeders;

use App\Enums\LectureTypeEnum;
use App\Models\Lecture;
use Illuminate\Database\Seeder;

class LecturesTableSeeder extends Seeder
{
    public function run(): void
    {
        $lectures = [
            ['center_id' => 1, 'section_id' => 1, 'teacher_id' => 4, 'date' => '2024-05-20', 'type' => LectureTypeEnum::EDUCATIONAL,],
            ['center_id' => 1, 'section_id' => 1, 'teacher_id' => 4, 'date' => '2024-05-21', 'type' => LectureTypeEnum::EDUCATIONAL_AND_TAJWEED,],
            ['center_id' => 1, 'section_id' => 1, 'teacher_id' => 4, 'date' => '2024-05-23', 'type' => LectureTypeEnum::EDUCATIONAL_AND_TAJWEED,],
            ['center_id' => 1, 'section_id' => 1, 'teacher_id' => 4, 'date' => '2024-05-24', 'type' => LectureTypeEnum::EDUCATIONAL,],
        ];

        foreach ($lectures as $lecture) {

            Lecture::create($lecture);

        }//end of for each

    }//end of run

}//end of seeder
