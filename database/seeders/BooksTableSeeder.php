<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'id' => 1,
                'name' => 'Triết học Mác Lê-nin',
                'number_of_pages' => 100,
                'image' => 'ebQbKRVpEhj6Vt8sEi9MgVsrepU63kd4sBlvffsn.jpg',
                'created_at' => '2025-07-05 08:18:06',
                'updated_at' => '2025-07-09 15:24:03',
            ],
            [
                'id' => 2,
                'name' => 'Giải tích',
                'number_of_pages' => 80,
                'image' => 'TPaQ5SwBda4g3976XAditgPF2yp5jdC5XihybFwm.jpg',
                'created_at' => '2025-07-05 08:18:06',
                'updated_at' => '2025-07-09 15:24:47',
            ],
            [
                'id' => 4,
                'name' => 'Kinh tế lượng',
                'number_of_pages' => 129,
                'image' => '0syU3NG064L4yC2S1sh2c95o8UB1DqrksasYmDg6.jpg',
                'created_at' => '2025-07-09 15:26:01',
                'updated_at' => '2025-07-09 15:26:01',
            ],
        ];

        foreach ($books as $book) {
            \App\Models\Book::create($book);
        }

    }//end of run

}//end of seeder
