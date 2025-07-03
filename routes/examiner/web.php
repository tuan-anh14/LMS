<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'set_selected_center', 'role:examiner', 'localization', 'no_cache'])->group(function () {

    Route::name('examiner.')->prefix('examiner')->group(function () {

        //home
        Route::get('/home', 'HomeController@index')->name('home');

        //teacher routes
        Route::get('/switch_language', 'TeacherController@switchLanguage')->name('switch_language');
        Route::get('/switch_center', 'TeacherController@switchCenter')->name('switch_center');
        Route::get('/leave_impersonate', 'TeacherController@leaveImpersonate')->name('leave_impersonate');

        //lecture routes
        Route::get('/lectures/data', 'LectureController@data')->name('lectures.data');
        Route::delete('/lectures/bulk_delete', 'LectureController@bulkDelete')->name('lectures.bulk_delete');
        Route::resource('lectures', 'LectureController');

        //student routes
        Route::get('/students/{student}/details', 'StudentController@details')->name('students.details');
        Route::get('/students/{student}/lectures', 'StudentController@lectures')->name('students.lectures');
        Route::get('/students/{student}/pages', 'StudentController@pages')->name('students.pages');
        Route::get('/students/{student}/exams', 'StudentController@exams')->name('students.exams');
        Route::get('/students/data', 'StudentController@data')->name('students.data');
        Route::delete('/students/bulk_delete', 'StudentController@bulkDelete')->name('students.bulk_delete');
        Route::resource('students', 'StudentController');

        //exam routes
        Route::get('/student_exams/{student_exam}/date_time', 'StudentExamController@editDateTime')->name('student_exams.edit_date_time');
        Route::put('/student_exams/{student_exam}/date_time', 'StudentExamController@updateDateTime')->name('student_exams.update_date_time');
        Route::get('/student_exams/{student_exam}/assessment', 'StudentExamController@editAssessment')->name('student_exams.edit_assessment');
        Route::put('/student_exams/{student_exam}/assessment', 'StudentExamController@updateAssessment')->name('student_exams.update_assessment');
        Route::get('/student_exams/data', 'StudentExamController@data')->name('student_exams.data');
        Route::resource('student_exams', 'StudentExamController');

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
