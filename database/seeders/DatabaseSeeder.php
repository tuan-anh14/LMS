<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountriesTableSeeder::class,
            GovernoratesTableSeeder::class,
            DegreesTableSeeder::class,
            LaratrustSeeder::class,
            UsersTableSeeder::class,
            LanguagesTableSeeder::class,
            CentersTableSeeder::class,
            BooksTableSeeder::class,
            ProjectsTableSeeder::class,
            SectionsTableSeeder::class,
            TeachersTableSeeder::class,
            StudentsTableSeeder::class,
            LecturesTableSeeder::class,
            ExamsTableSeeder::class,
            SlidesTableSeeder::class,
            CoursesTableSeeder::class,
        ]);
    }
}
