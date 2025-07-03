<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Project;
use App\Models\Role;
use App\Models\Section;
use App\Models\User;
use App\Models\Book;
use App\Models\Slide;

class HomeController extends Controller
{
    public function index()
    {
        $centers = Center::query()->count();
        $exams = Exam::query()->count();
        $projects = Project::query()->count();
        $courses = Course::query()->count();
        $slides = Slide::query()->count();
        $sections = Section::query()->count();
        $books = Book::query()->count();
        //$roles = Role::query()->count();
        $roles = Role::whereNotIn('name', [
            UserTypeEnum::SUPER_ADMIN,
            UserTypeEnum::ADMIN,
            UserTypeEnum::TEACHER,
            UserTypeEnum::STUDENT,
            UserTypeEnum::CENTER_MANAGER,
            UserTypeEnum::EXAMINER,
        ])
            ->withCount(['users'])->count();

        $examiners = User::query()->where('type', UserTypeEnum::EXAMINER)->count();
        $admins = User::query()->where('type', UserTypeEnum::ADMIN)->count();
        $teachers = User::query()->where('type', UserTypeEnum::TEACHER)->count();
        $students = User::query()->where('type', UserTypeEnum::STUDENT)->count();

        //dd($teachers);

        return view('admin.home', compact('centers', 'teachers', 'students',
            'exams', 'projects', 'courses', 'slides', 'sections', 'books', 'roles', 'examiners', 'admins'));

    }// end of index

}//end of controller
