<?php

namespace Database\Seeders;

use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'first_name' => 'mohamad',
            'second_name' => 'salahia',
            'nickname' => 'developer',
            'email' => 'admin@webseity.com',
            'password' => bcrypt('demo1234'),
            'type' => 'super_admin',
            'image' => 'profile.png',
        ]);

        $user->attachRole('super_admin');

        $admins = [
            [
                'first_name' => 'ادمن 1',
                'second_name' => null,
                'email' => 'admin1@app.com',
                'password' => bcrypt('password'),
                'type' => UserTypeEnum::ADMIN,
            ],
            [
                'first_name' => 'ادمن 2',
                'second_name' => null,
                'email' => 'admin2@app.com',
                'password' => bcrypt('password'),
                'type' => UserTypeEnum::ADMIN,
            ],
        ];

        foreach ($admins as $admin) {

            $newAdmin = User::create($admin);

            $newAdmin->attachRole('admin');

        }//end of for each

    }//end of run

}//end of seeder
