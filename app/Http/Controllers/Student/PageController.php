<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{
    public function data()
    {
        //dd(auth()->user()->id);
        $student = User::query()->where('id', auth()->user()->id)->first();
        //dd($student);

        $pages = Page::query()
            ->with(['center', 'section', 'book', 'teacher', 'student', 'studentLecture.lecture'])
            ->whenStudentId(auth()->user()->id)
            ->whenBookId($student ? $student->studentProject->book_id : null)
            ->whenLectureId(request()->lecture_id)
            ->whenAssessment(request()->assessment);

        return DataTables::of($pages)
            ->addColumn('section', function (Page $page) {
                return $page->section->name;
            })
            ->addColumn('book', function (Page $page) {
                return $page->book->name;
            })
            ->addColumn('teacher', function (Page $page) {
                return $page->teacher->name;
            })
            ->addColumn('lecture', function (Page $page) {
                return $page->studentLecture->lecture->name;
            })
            ->addColumn('assessment', function (Page $page) {
                return __('pages.' . $page->assessment);
            })
            ->editColumn('created_at', function (Page $page) {
                return $page->created_at->format('Y-m-d');
            })
            ->rawColumns([])
            ->toJson();

    }// end of data

}//end of controller
