<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'id' => 1,
                'book_id' => 1,
                'title' => 'Triết học Mác Lê nin',
                'short_description' => 'Khóa học tìm hiểu Triết học Mác -Lê nin online',
                'description' => 'Khóa học tìm hiểu Triết học Mác -Lê nin online',
                'image' => 'O1h6eNdBCNUK0UeOXyTakWyYxZKppekC3TgE30Zd.jpg',
                'created_at' => '2025-07-05 08:18:07',
                'updated_at' => '2025-07-09 16:54:51',
            ],
            [
                'id' => 2,
                'book_id' => 2,
                'title' => 'Giải tích',
                'short_description' => 'Khoá học Làm chủ Hình học giải tích trong mặt phẳng Oxy | Học toán online chất lượng cao 2025 | Vted',
                'description' => 'Khoá học Làm chủ Hình học giải tích trong mặt phẳng Oxy | Học toán online chất lượng cao 2025 | Vted',
                'image' => 'HQA3loGsr8pblwkSF7weVGgw3tFCgD9BvbTe3xNJ.png',
                'created_at' => '2025-07-05 08:18:07',
                'updated_at' => '2025-07-09 16:56:55',
            ],
            [
                'id' => 3,
                'book_id' => 4,
                'title' => 'Kinh tế lượng',
                'short_description' => 'Kinh tế lượng ứng dụng | ATD',
                'description' => 'Kinh tế lượng ứng dụng | ATD',
                'image' => 'hxrLgyxxoTFDBjiDMX2FfGaotCNvrmYskY9OIUwi.png',
                'created_at' => '2025-07-05 08:18:07',
                'updated_at' => '2025-07-09 17:00:58',
            ],
        ];

        foreach ($courses as $course) {
            \App\Models\Course::create($course);
        }

    }//end of run

}//end of seeder
