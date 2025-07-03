<?php

namespace Database\Seeders;

use App\Enums\GenderEnum;
use App\Enums\ReadingTypeEnum;
use App\Enums\UserTypeEnum;
use App\Models\User;
use App\Services\StudentService;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'country_id' => 1,
                'governorate_id' => 1,
                'first_name' => 'طالب ',
                'second_name' => '1',
                'email' => 'student1@app.com',
                'password' => bcrypt('password'),
                'mobile' => '01000000005',
                'dob' => '1985-01-01',
                'gender' => GenderEnum::MALE,
                'address' => 'Address 1',
                'type' => UserTypeEnum::STUDENT,
                'student_center_id' => 1,
                'student_project_id' => 1,
                'student_section_id' => 1,
                'reading_type' => ReadingTypeEnum::INDIVIDUAL,
            ],

            [
                'country_id' => 1,
                'governorate_id' => 1,
                'first_name' => 'طالب',
                'second_name' => '2',
                'email' => 'student2@app.com',
                'password' => bcrypt('password'),
                'mobile' => '01000000006',
                'dob' => '1985-01-01',
                'gender' => GenderEnum::MALE,
                'address' => 'Address 1',
                'type' => UserTypeEnum::STUDENT,
                'student_center_id' => 1,
                'student_project_id' => 1,
                'student_section_id' => 1,
                'reading_type' => ReadingTypeEnum::GROUP,
            ],

            [
                'country_id' => 1,
                'governorate_id' => 1,
                'first_name' => 'طالب',
                'second_name' => '3',
                'email' => 'student3@app.com',
                'password' => bcrypt('password'),
                'mobile' => '01000000008',
                'dob' => '1985-01-01',
                'gender' => GenderEnum::MALE,
                'address' => 'Address 1',
                'type' => UserTypeEnum::STUDENT,
                'student_center_id' => 1,
                'student_project_id' => 1,
                'student_section_id' => 1,
                'reading_type' => ReadingTypeEnum::INDIVIDUAL,

            ],

            [
                'country_id' => 1,
                'governorate_id' => 1,
                'first_name' => 'طالب',
                'second_name' => '4',
                'email' => 'student4@app.com',
                'password' => bcrypt('password'),
                'mobile' => '01000000009',
                'dob' => '1985-01-01',
                'gender' => GenderEnum::MALE,
                'address' => 'Address 1',
                'type' => UserTypeEnum::STUDENT,
                'student_center_id' => 1,
                'student_project_id' => 1,
                'student_section_id' => 1,
                'reading_type' => ReadingTypeEnum::GROUP,
            ],

            [
                'country_id' => 1,
                'governorate_id' => 1,
                'first_name' => 'طالب',
                'second_name' => '5',
                'email' => 'student5@app.com',
                'password' => bcrypt('password'),
                'mobile' => '01000000010',
                'dob' => '1985-01-01',
                'gender' => GenderEnum::MALE,
                'address' => 'Address 1',
                'type' => UserTypeEnum::STUDENT,
                'student_center_id' => 1,
                'student_project_id' => 1,
                'student_section_id' => 1,
                'reading_type' => ReadingTypeEnum::INDIVIDUAL,
            ],

        ];

        foreach ($students as $student) {

            $newStudent = User::create($student);

            $newStudent->attachRole(UserTypeEnum::STUDENT);

            $studentService = new StudentService();

            $studentService->storeStudentLogs($newStudent);

        }//end of for each

    }//end of run

}//end of seeder
