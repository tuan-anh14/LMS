<?php

namespace App\Http\Controllers\Examiner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\LectureRequest;
use App\Models\Lecture;
use App\Models\Section;
use Yajra\DataTables\DataTables;

class LectureController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_lectures')->only(['index']);
        $this->middleware('permission:create_lectures')->only(['create', 'store']);
        $this->middleware('permission:update_lectures')->only(['edit', 'update']);
        $this->middleware('permission:delete_lectures')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $sections = auth()->user()->hasRole('center_manager')
            ? Section::query()
                ->where('center_id', session('selected_center')['id'])
                ->get()
            : auth()->user()->teacherSections()
                ->get();

        return view('examiner.lectures.index', compact('sections'));

    }// end of index

    public function data()
    {
        $lectures = Lecture::query()
            ->with(['teacher', 'section', 'center', 'students'])
            ->whenCenterId(session('selected_center')['id'])
            ->whenSectionId(request()->section_id)
            ->whenTeacherId(auth()->user()->hasRole('center_manager') ? request()->teacher_id : auth()->user()->id)
            ->whenDate(request()->date)
            ->whenDateRange(request()->date_range)
            ->whenStudentId(request()->student_id)
            ->whenAttendanceStatus(request()->attendance_status)
            ->whenType(request()->type);

        return DataTables::of($lectures)
            ->addColumn('record_select', 'examiner.lectures.data_table.record_select')
            ->addColumn('name', function (Lecture $lecture) {
                return $lecture->name;
            })
            ->addColumn('attendance_status', function (Lecture $lecture) {
                return request()->student_id
                    ? __('lectures.' . $lecture->students->where('id', request()->student_id)->first()->pivot->attendance_status)
                    : null;
            })
            ->addColumn('center', function (Lecture $lecture) {
                return $lecture->center->name;
            })
            ->addColumn('section', function (Lecture $lecture) {
                return $lecture->section->name;
            })
            ->addColumn('type', function (Lecture $lecture) {
                return __('lectures.' . $lecture->type);
            })
            ->editColumn('created_at', function (Lecture $lecture) {
                return $lecture->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'examiner.lectures.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        $sections = auth()->user()->teacherSections()
            ->where('teacher_center_section.center_id', session('selected_center')['id'])
            ->get();

        return view('examiner.lectures.create', compact('sections'));

    }// end of create

    public function store(LectureRequest $request)
    {
        Lecture::create($request->validated());

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('examiner.lectures.index'),
        ]);

    }// end of store

    public function edit(Lecture $lecture)
    {
        $lecture->load(['section', 'section.project']);

        $sections = auth()->user()->teacherSections()
            ->where('teacher_center_section.center_id', session('selected_center')['id'])
            ->get();

        return view('examiner.lectures.edit', compact('sections', 'lecture'));

    }// end of edit

    public function update(LectureRequest $request, Lecture $lecture)
    {
        $lecture->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('examiner.lectures.index'),
        ]);

    }// end of update

    public function destroy(Lecture $lecture)
    {
        $this->delete($lecture);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $lecture = Teacher::FindOrFail($recordId);
            $this->delete($lecture);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(Lecture $lecture)
    {
        $lecture->delete();

    }// end of delete

}//end of controller
