<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Inquiry;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class WebController extends Controller
{
    public function __construct()
    {
        $courses = Course::all();

        View::share('courses', $courses);

    }//end of construct

    public function index()
    {
        $slides = Slide::all();

        return view('index', compact('slides'));

    }//end of index

    public function courses()
    {
        return view('courses');

    }//end of courses

    public function single_course($id)
    {
        return view('single_course');

    }//end of visuals

    public function about_us()
    {
        return view('about_us');

    }//end of about_us

    public function contact_us()
    {
        return view('contact_us');

    }//end of contact_us

    public function visuals()
    {
        return view('visuals');

    }//end of visuals

    public function inquiries(Request $request)
    {

        request()->validate([
            'title' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);
        $data = $request->except(['_token', '_method']);
        Inquiry::create($data);
        session()->flash('contact_success', __('site.send_successfully'));
        return redirect(url()->previous() . '#contact-sent');

    }//end of inquiries


}//end of controller
