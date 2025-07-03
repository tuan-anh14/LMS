<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class CourseController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_courses')->only(['index']);
        $this->middleware('permission:create_courses')->only(['create', 'store']);
        $this->middleware('permission:update_courses')->only(['edit', 'update']);
        $this->middleware('permission:delete_courses')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        return view('admin.courses.index');

    }// end of index

    public function data()
    {
        $courses = Course::query();

        return DataTables::of($courses)
            ->addColumn('record_select', 'admin.courses.data_table.record_select')
            ->addColumn('image', function (Course $course) {
                return view('admin.courses.data_table.image', compact('course'));
            })
            ->editColumn('created_at', function (Course $course) {
                return $course->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.courses.data_table.actions')
            ->addColumn('status', 'admin.courses.data_table.status')
            ->rawColumns(['record_select', 'image', 'actions', 'status'])
            ->toJson();

    }// end of data

    public function create()
    {
        return view('admin.courses.create');

    }// end of create

    public function store(CourseRequest $request)
    {
        $requestData = $request->validated();

        if ($request->file('image')) {
            $requestData['image'] = $request->file('image')->hashName();
            $request->file('image')->store('public/uploads');
        }

        Course::create($requestData);

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.courses.index'),
        ]);

    }// end of store

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));

    }// end of edit

    public function update(CourseRequest $request, Course $course)
    {
        $requestData = $request->validated();

        if ($request->file('image')) {
            Storage::disk('local')->delete('public/uploads/' . $course->image);
            $requestData['image'] = $request->file('image')->hashName();
            $request->file('image')->store('public/uploads');
        }

        $course->update($requestData);

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.courses.index'),
        ]);

    }// end of update

    public function destroy(Course $course)
    {
        $this->delete($course);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $course = Course::FindOrFail($recordId);
            $this->delete($course);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(Course $course)
    {
        $course->delete();

    }// end of delete

}//end of controller
