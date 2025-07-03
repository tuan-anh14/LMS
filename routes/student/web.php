<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:student', 'localization'])->group(function () {

    Route::name('student.')->prefix('student')->group(function () {

        //home
        Route::get('/home', 'HomeController@index')->name('home');

        Route::get('/leave_impersonate', 'StudentController@leaveImpersonate')->name('leave_impersonate');

        Route::get('/details', 'HomeController@details')->name('details');
        Route::get('/logs', 'HomeController@logs')->name('logs');
        Route::get('/pages', 'HomeController@pages')->name('pages');

        Route::get('/logs/data', 'LogController@data')->name('logs.data');
        Route::get('/pages/data', 'PageController@data')->name('pages.data');

        //student_exam routes
        Route::get('/student_exams/data', 'StudentExamController@data')->name('student_exams.data');
        Route::resource('student_exams', 'StudentExamController')->only(['index', 'show']);

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
