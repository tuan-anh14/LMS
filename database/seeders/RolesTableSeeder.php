<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
                'description' => 'Super Admin',
                'created_at' => '2025-07-09 15:45:51',
                'updated_at' => '2025-07-09 15:45:51',
            ],
            [
                'id' => 2,
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Admin',
                'created_at' => '2025-07-09 15:45:52',
                'updated_at' => '2025-07-09 15:45:52',
            ],
            [
                'id' => 3,
                'name' => 'teacher',
                'display_name' => 'Teacher',
                'description' => 'Teacher',
                'created_at' => '2025-07-09 15:45:52',
                'updated_at' => '2025-07-09 15:45:52',
            ],
            [
                'id' => 4,
                'name' => 'student',
                'display_name' => 'Student',
                'description' => 'Student',
                'created_at' => '2025-07-09 15:45:52',
                'updated_at' => '2025-07-09 15:45:52',
            ],
            [
                'id' => 5,
                'name' => 'center_manager',
                'display_name' => 'Center Manager',
                'description' => 'Center Manager',
                'created_at' => '2025-07-09 15:45:52',
                'updated_at' => '2025-07-09 15:45:52',
            ],
            [
                'id' => 6,
                'name' => 'examiner',
                'display_name' => 'Examiner',
                'description' => 'Examiner',
                'created_at' => '2025-07-09 15:45:52',
                'updated_at' => '2025-07-09 15:45:52',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
} 