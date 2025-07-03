<?php

namespace Database\Seeders;

use App\Enums\GenderEnum;
use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'country_id' => 1,
                'governorate_id' => 1,
                'degree_id' => 1,
                'first_name' => 'معلم',
                'second_name' => '1',
                'nickname' => 'كنية 1',
                'email' => 'teacher1@app.com',
                'password' => bcrypt('password'),
                'mobile' => '01000000001',
                'dob' => '1985-01-01',
                'gender' => GenderEnum::MALE,
                'address' => 'Address 1',
                'type' => UserTypeEnum::TEACHER,
                'centers' => [
                    [
                        'center_id' => 1,
                        'section_ids' => [1, 2, 3],
                    ],
                    [
                        'center_id' => 2,
                        'section_ids' => [4, 5],
                    ],
                ],
                'centers_as_manager' => [1],
                'is_examiner' => 1,
            ],

            [
                'country_id' => 1,
                'governorate_id' => 1,
                'degree_id' => 1,
                'first_name' => 'معلم',
                'second_name' => '2',
                'nickname' => 'كنية 2',
                'email' => 'teacher2@app.com',
                'password' => bcrypt('password'),
                'mobile' => '01000000002',
                'dob' => '1985-01-01',
                'gender' => GenderEnum::MALE,
                'address' => 'Address 2',
                'type' => UserTypeEnum::TEACHER,
                'centers' => [
                    [
                        'center_id' => 1,
                        'section_ids' => [1, 2, 3],
                    ],
                ],
                'is_examiner' => 1,
            ],

            [
                'country_id' => 1,
                'governorate_id' => 1,
                'degree_id' => 1,
                'first_name' => 'معلم',
                'second_name' => '3',
                'nickname' => 'كنية 3',
                'email' => 'teacher3@app.com',
                'password' => bcrypt('password'),
                'mobile' => '01000000003',
                'dob' => '1985-01-01',
                'gender' => GenderEnum::MALE,
                'address' => 'Address 3',
                'type' => UserTypeEnum::TEACHER,
                'centers' => [
                    [
                        'center_id' => 1,
                        'section_ids' => [1, 2, 3],
                    ],
                ],
                'is_examiner' => 1,
            ],

        ];

        foreach ($teachers as $teacher) {

            $newTeacher = User::create(collect($teacher)->except(['centers', 'centers_as_manager'])->toArray());

            $newTeacher->attachRole(UserTypeEnum::TEACHER);

            foreach ($teacher['centers'] as $center) {

                $newTeacher->syncRolesWithoutDetaching([UserTypeEnum::TEACHER], $center['center_id']);

                $newTeacher->teacherCenters()->attach($center['center_id']);

                foreach ($center['section_ids'] as $sectionId) {

                    $newTeacher->teacherSections()->attach(
                        $sectionId,
                        [
                            'center_id' => $center['center_id']
                        ]
                    );

                }//end of for each

            }//end of for each

            if (array_key_exists('centers_as_manager', $teacher)) {

                foreach ($teacher['centers_as_manager'] as $centerId) {

                    $newTeacher->attachRole(UserTypeEnum::CENTER_MANAGER, $centerId);

                    $newTeacher->managerCenters()->attach($centerId);

                }//end of for each

            }

            if ($teacher['is_examiner']) {

                $newTeacher->attachRole(UserTypeEnum::EXAMINER);

            }
        }//end of for each

    }//end of run

}//end of seeder
