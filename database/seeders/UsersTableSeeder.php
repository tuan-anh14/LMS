<?php

namespace Database\Seeders;

use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'country_id' => null,
                'governorate_id' => null,
                'degree_id' => null,
                'student_center_id' => null,
                'student_section_id' => null,
                'student_project_id' => null,
                'first_name' => 'Admin',
                'second_name' => 'Super',
                'nickname' => 'developer',
                'name' => 'Admin Super',
                'email' => 'admin@webseity.com',
                'mobile' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$RqoM77VqB7TAGuBAv5XP2.LUQLie32LVY1LR.0sJ0Cu9fOENSxppW',
                'type' => 'super_admin',
                'reading_type' => null,
                'image' => 'btwEON37HUtDpwPm17JPThasmhSgTmdd7xMHqNXZ.png',
                'locale' => 'vi',
                'address' => null,
                'dob' => null,
                'gender' => 'male',
                'is_examiner' => 0,
                'remember_token' => null,
                'registration_date' => null,
                'created_at' => '2025-07-05 08:18:06',
                'updated_at' => '2025-07-09 15:54:42',
            ],
            [
                'country_id' => null,
                'governorate_id' => null,
                'degree_id' => null,
                'student_center_id' => null,
                'student_section_id' => null,
                'student_project_id' => null,
                'first_name' => 'Admin',
                'second_name' => '1',
                'nickname' => 'Admin 1',
                'name' => 'Admin 1',
                'email' => 'admin1@app.com',
                'mobile' => null,
                'email_verified_at' => null,
                'password' => '$2y$10$0YPifwbe0A3qDu2X1iUFW.bKG.8DIZBT6.hOaPX7eoVUz7Fe13XWy',
                'type' => 'admin',
                'reading_type' => null,
                'image' => null,
                'locale' => 'ar',
                'address' => null,
                'dob' => null,
                'gender' => 'male',
                'is_examiner' => 0,
                'remember_token' => null,
                'registration_date' => null,
                'created_at' => '2025-07-05 08:18:06',
                'updated_at' => '2025-07-09 08:35:57',
            ],
            // ... (Các user còn lại sẽ được dán đầy đủ từ users.json)
        ];

        foreach ($users as $user) {
            $createdUser = \App\Models\User::create($user);
            // Gán role tự động sau khi tạo user
            if ($user['email'] === 'admin@webseity.com') {
                $createdUser->attachRole('super_admin');
            }
            if ($user['email'] === 'admin1@app.com') {
                $createdUser->attachRole('admin');
            }
        }

    }//end of run

}//end of seeder
