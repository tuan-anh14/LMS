<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'set_selected_center', 'role:teacher', 'localization', 'no_cache'])->group(function () {

    Route::name('teacher.')->prefix('teacher')->group(function () {

        //home
        Route::get('/home', 'HomeController@index')->name('home');

        //country routes
        Route::get('/countries/{country}/governorates', 'CountryController@governorates')->name('countries.governorates');

        //governorate routes
        Route::get('/governorates/{governorate}/areas', 'GovernorateController@areas')->name('governorates.areas');

        //teacher routes
        Route::get('/switch_language', 'TeacherController@switchLanguage')->name('switch_language');
        Route::get('/switch_center', 'TeacherController@switchCenter')->name('switch_center');
        Route::get('/leave_impersonate', 'TeacherController@leaveImpersonate')->name('leave_impersonate');

        //center routes
        Route::get('/centers/{center}/projects', 'CenterController@projects')->name('centers.projects');

        //project routes
        Route::get('/projects/{project}/sections', 'ProjectController@sections')->name('projects.sections');
        Route::get('/projects/data', 'ProjectController@data')->name('projects.data');
        Route::delete('/projects/bulk_delete', 'ProjectController@bulkDelete')->name('projects.bulk_delete');
        Route::resource('projects', 'ProjectController');

        //book routes
        Route::get('/books/data', 'BookController@data')->name('books.data');
        Route::delete('/books/bulk_delete', 'BookController@bulkDelete')->name('books.bulk_delete');
        Route::resource('books', 'BookController');

        //section routes
        Route::get('/sections/{section}/lecture_types', 'SectionController@lectureTypes')->name('sections.lecture_types');
        Route::get('/sections/data', 'SectionController@data')->name('sections.data');
        Route::delete('/sections/bulk_delete', 'SectionController@bulkDelete')->name('sections.bulk_delete');
        Route::resource('sections', 'SectionController');

        //lecture routes
        Route::get('/lectures/data', 'LectureController@data')->name('lectures.data');
        Route::delete('/lectures/bulk_delete', 'LectureController@bulkDelete')->name('lectures.bulk_delete');
        Route::resource('lectures', 'LectureController');

        //teacher routes
        Route::get('/teachers/data', 'TeacherController@data')->name('teachers.data');
        Route::delete('/teachers/bulk_delete', 'TeacherController@bulkDelete')->name('teachers.bulk_delete');
        Route::resource('teachers', 'TeacherController');

        //lecture routes
        Route::get('/student_lectures/data', 'StudentLectureController@data')->name('student_lectures.data');
        Route::resource('student_lectures', 'StudentLectureController');

        //exam routes
        Route::resource('exams', 'ExamController');

        //exam routes
        Route::get('/student_exams/{student_exam}/date_time', 'StudentExamController@editDateTime')->name('student_exams.edit_date_time');
        Route::put('/student_exams/{student_exam}/date_time', 'StudentExamController@updateDateTime')->name('student_exams.update_date_time');
        Route::get('/student_exams/{student_exam}/assessment', 'StudentExamController@editAssessment')->name('student_exams.edit_assessment');
        Route::put('/student_exams/{student_exam}/assessment', 'StudentExamController@updateAssessment')->name('student_exams.update_assessment');
        Route::get('/student_exams/data', 'StudentExamController@data')->name('student_exams.data');
        Route::resource('student_exams', 'StudentExamController');

        //student routes
        Route::get('/students/{student}/details', 'StudentController@details')->name('students.details');
        Route::get('/students/{student}/lectures', 'StudentController@lectures')->name('students.lectures');
        Route::get('/students/{student}/pages', 'StudentController@pages')->name('students.pages');
        Route::get('/students/{student}/exams', 'StudentController@exams')->name('students.exams');
        Route::get('/students/data', 'StudentController@data')->name('students.data');
        Route::delete('/students/bulk_delete', 'StudentController@bulkDelete')->name('students.bulk_delete');
        Route::resource('students', 'StudentController');

        //page routes
        Route::get('/pages/data', 'PageController@data')->name('pages.data');

        //profile routes
        Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
        Route::put('/profile/update', 'ProfileController@update')->name('profile.update');

        Route::name('profile.')->namespace('Profile')->group(function () {

            //password routes
            Route::get('/password/edit', 'PasswordController@edit')->name('password.edit');
            Route::put('/password/update', 'PasswordController@update')->name('password.update');

        });

    });

});
