<?php

use App\Http\Controllers\Student\HomeController;
use App\Http\Controllers\Student\LogController;
use App\Http\Controllers\Student\PageController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\Profile\PasswordController;
use App\Http\Controllers\Student\StudentExamController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:student', 'localization'])->group(function () {

    Route::name('student.')->prefix('student')->group(function () {

        //home
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::get('/leave_impersonate', [HomeController::class, 'leaveImpersonate'])->name('leave_impersonate');

        Route::get('/details', [HomeController::class, 'details'])->name('details');
        Route::get('/logs', [HomeController::class, 'logs'])->name('logs');
        Route::get('/pages', [HomeController::class, 'pages'])->name('pages');

        Route::get('/logs/data', [LogController::class, 'data'])->name('logs.data');
        Route::get('/pages/data', [PageController::class, 'data'])->name('pages.data');

        //student_exam routes
        Route::get('/student_exams/data', [StudentExamController::class, 'data'])->name('student_exams.data');
        Route::resource('student_exams', StudentExamController::class)->only(['index', 'show']);
        Route::get('student_exams/{studentExam}/take', [StudentExamController::class, 'take'])->name('student_exams.take');
        Route::post('student_exams/{studentExam}/submit', [StudentExamController::class, 'submit'])->name('student_exams.submit');
        Route::get('student_exams/{studentExam}/results', [StudentExamController::class, 'results'])->name('student_exams.results');

        //profile routes
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::name('profile.')->group(function () {

            //password routes
            Route::get('/password/edit', [PasswordController::class, 'edit'])->name('password.edit');
            Route::put('/password/update', [PasswordController::class, 'update'])->name('password.update');

        });

        Route::get('/switch_language/{locale}', [\App\Http\Controllers\Student\ProfileController::class, 'switchLanguage'])->name('switch_language');

    });

});
