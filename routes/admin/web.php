<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CenterController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DegreeController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\ExaminerController;
use App\Http\Controllers\Admin\GovernorateController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\Profile\PasswordController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentLectureController;
use App\Http\Controllers\Admin\TeacherController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:admin|super_admin', 'localization', 'no_cache', 'demo_mode'])->group(function () {

    Route::name('admin.')->prefix('admin')->group(function () {

        Route::get('/fix_permission_for_bashar', function () {

            $user = User::find(12);

            $user->attachRole('teacher');

            return 'done';

        })->name('');

        //home
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        //role routes
        Route::get('/roles/data', [RoleController::class, 'data'])->name('roles.data');
        Route::delete('/roles/bulk_delete', [RoleController::class, 'bulkDelete'])->name('roles.bulk_delete');
        Route::resource('roles', RoleController::class);

        //admin routes
        Route::get('/admin/switch_language', [AdminController::class, 'switchLanguage'])->name('admin.switch_language');
        Route::get('/admins/data', [AdminController::class, 'data'])->name('admins.data');
        Route::delete('/admins/bulk_delete', [AdminController::class, 'bulkDelete'])->name('admins.bulk_delete');
        Route::resource('admins', AdminController::class);

        //slide routes
        Route::get('/slides/data', [SlideController::class, 'data'])->name('slides.data');
        Route::delete('/slides/bulk_delete', [SlideController::class, 'bulkDelete'])->name('slides.bulk_delete');
        Route::resource('slides', SlideController::class);

        //course routes
        Route::get('/courses/data', [CourseController::class, 'data'])->name('courses.data');
        Route::delete('/courses/bulk_delete', [CourseController::class, 'bulkDelete'])->name('courses.bulk_delete');
        Route::resource('courses', CourseController::class);

        //inquiry routes
        Route::get('/inquiries/data', [InquiryController::class, 'data'])->name('inquiries.data');
        Route::delete('/inquiries/bulk_delete', [InquiryController::class, 'bulkDelete'])->name('inquiries.bulk_delete');
        Route::resource('inquiries', InquiryController::class)->only(['index', 'show', 'destroy']);

        //service routes
        Route::get('/services/data', [ServiceController::class, 'data'])->name('services.data');
        Route::delete('/services/bulk_delete', [ServiceController::class, 'bulkDelete'])->name('services.bulk_delete');
        Route::resource('services', ServiceController::class);

        //center routes
        Route::get('/centers/{center}/projects', [CenterController::class, 'projects'])->name('centers.projects');
        Route::get('/centers/data', [CenterController::class, 'data'])->name('centers.data');
        Route::delete('/centers/bulk_delete', [CenterController::class, 'bulkDelete'])->name('centers.bulk_delete');
        Route::resource('centers', CenterController::class);

        //project routes
        Route::get('/projects/{project}/sections', [ProjectController::class, 'sections'])->name('projects.sections');
        Route::get('/projects/data', [ProjectController::class, 'data'])->name('projects.data');
        Route::delete('/projects/bulk_delete', [ProjectController::class, 'bulkDelete'])->name('projects.bulk_delete');
        Route::resource('projects', ProjectController::class);

        //section routes
        Route::get('/sections/data', [SectionController::class, 'data'])->name('sections.data');
        Route::delete('/sections/bulk_delete', [SectionController::class, 'bulkDelete'])->name('sections.bulk_delete');
        Route::resource('sections', SectionController::class);

        //book routes
        Route::get('/books/data', [BookController::class, 'data'])->name('books.data');
        Route::delete('/books/bulk_delete', [BookController::class, 'bulkDelete'])->name('books.bulk_delete');
        Route::resource('books', BookController::class);

        //teacher routes
        Route::get('teachers/{teacher}/details', [TeacherController::class, 'details'])->name('teachers.details');
        Route::get('teachers/{teacher}/student_lectures', [TeacherController::class, 'studentLectures'])->name('teachers.student_lectures');
        Route::get('teachers/{teacher}/impersonate', [TeacherController::class, 'impersonate'])->name('teachers.impersonate');
        Route::get('/teachers/data', [TeacherController::class, 'data'])->name('teachers.data');
        Route::delete('/teachers/bulk_delete', [TeacherController::class, 'bulkDelete'])->name('teachers.bulk_delete');
        Route::resource('teachers', TeacherController::class);

        //student lecture routes
        Route::get('/student_lectures/data', [StudentLectureController::class, 'data'])->name('student_lectures.data');

        //examiners routes
        Route::get('examiners/{examiner}/impersonate', [ExaminerController::class, 'impersonate'])->name('examiners.impersonate');
        Route::get('/examiners/data', [ExaminerController::class, 'data'])->name('examiners.data');
        Route::delete('/examiners/bulk_delete', [ExaminerController::class, 'bulkDelete'])->name('examiners.bulk_delete');
        Route::resource('examiners', ExaminerController::class);

        //student routes
        Route::get('students/{student}/impersonate', [StudentController::class, 'impersonate'])->name('students.impersonate');
        Route::get('/students/{student}/details', [StudentController::class, 'details'])->name('students.details');
        Route::get('/students/{student}/logs', [StudentController::class, 'logs'])->name('students.logs');
        Route::get('/students/data', [StudentController::class, 'data'])->name('students.data');
        Route::delete('/students/bulk_delete', [StudentController::class, 'bulkDelete'])->name('students.bulk_delete');
        Route::resource('students', StudentController::class);

        //exam routes
        Route::get('/exams/data', [ExamController::class, 'data'])->name('exams.data');
        Route::delete('/exams/bulk_delete', [ExamController::class, 'bulkDelete'])->name('exams.bulk_delete');
        Route::resource('exams', ExamController::class);

        //log routes
        Route::get('/logs/data', [LogController::class, 'data'])->name('logs.data');
        Route::resource('logs', LogController::class)->only(['index']);

        //setting routes
        Route::get('/settings/general_data', [SettingController::class, 'generalData'])->name('settings.general_data');
        Route::post('/settings/general_data', [SettingController::class, 'storeGeneralData'])->name('settings.general_data');

        //country routes
        Route::get('/countries/{country}/governorates', [CountryController::class, 'governorates'])->name('countries.governorates');
        Route::get('/countries/data', [CountryController::class, 'data'])->name('countries.data');
        Route::delete('/countries/bulk_delete', [CountryController::class, 'bulkDelete'])->name('countries.bulk_delete');
        Route::resource('countries', CountryController::class);

        //governorate routes
        Route::get('/governorates/{governorate}/areas', [GovernorateController::class, 'areas'])->name('governorates.areas');
        Route::get('/governorates/data', [GovernorateController::class, 'data'])->name('governorates.data');
        Route::delete('/governorates/bulk_delete', [GovernorateController::class, 'bulkDelete'])->name('governorates.bulk_delete');
        Route::resource('governorates', GovernorateController::class);

        //degree routes
        Route::get('/degrees/data', [DegreeController::class, 'data'])->name('degrees.data');
        Route::delete('/degrees/bulk_delete', [DegreeController::class, 'bulkDelete'])->name('degrees.bulk_delete');
        Route::resource('degrees', DegreeController::class);

        //profile routes
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::name('profile.')->namespace('Profile')->group(function () {


            //password routes
            Route::get('/password/edit', [PasswordController::class, 'edit'])->name('password.edit');
            Route::put('/password/update', [PasswordController::class, 'update'])->name('password.update');

        });

    });

});
