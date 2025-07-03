<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('student.home');

    }// end of index

    public function details()
    {
        return view('student._details');

    }// end of details

    public function logs()
    {
        return view('student._logs');

    }// end of logs

    public function pages()
    {
        return view('student._pages');

    }// end of pages

    public function lectures()
    {
        return view('student._lectures');

    }// end of lectures

}//end of controller
