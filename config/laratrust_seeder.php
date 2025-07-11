<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super_admin' => [
            'roles' => 'c,r,u,d',
            'admins' => 'c,r,u,d',
            'students' => 'c,r,u,d',
            'sections' => 'c,r,u,d',
            'teachers' => 'c,r,u,d',
            'examiners' => 'c,r,u,d',
            'centers' => 'c,r,u,d',
            'projects' => 'c,r,u,d',
            'sections' => 'c,r,u,d',
            'settings' => 'c,r,u,d',
            'countries' => 'c,r,u,d',
            'governorates' => 'c,r,u,d',
            'areas' => 'c,r,u,d',
            'degrees' => 'c,r,u,d',
            'books' => 'c,r,u,d',
            'exams' => 'c,r,u,d',
            'slides' => 'c,r,u,d',
            'courses' => 'c,r,u,d',
            'inquiries' => 'r,d',
            'services' => 'c,r,u,d',
        ],
        'admin' => [],
        'teacher' => [
            'students' => 'r',
            'lectures' => 'c,r,u,d',
            'exams' => 'c,r,u,d',
        ],
        'student' => [],
        'center_manager' => [
            'teachers' => 'r',
            'students' => 'r',
            'sections' => 'r',
            'projects' => 'r',
            'books' => 'r',
        ],
        'examiner' => [
            'student_exams' => 'r,u',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
