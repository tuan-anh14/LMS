<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentRequest;
use App\Models\Center;
use App\Models\Country;
use App\Models\User;
use App\Services\StudentService;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_students')->only(['index']);
        $this->middleware('permission:create_students')->only(['create', 'store']);
        $this->middleware('permission:update_students')->only(['edit', 'update']);
        $this->middleware('permission:delete_students')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $countries = Country::query()
            ->get();

        $centers = Center::query()
            ->get();

        return view('admin.students.index', compact('countries', 'centers'));

    }// end of index

    public function data()
    {
        $students = User::query()
            ->with(['country', 'governorate', 'degree'])
            ->select([
                DB::raw("CONCAT(first_name, ' ', second_name) as full_name"),
                'users.*'
            ])
            ->whenCountryId(request()->country_id)
            ->whenGovernorateId(request()->governorate_id)
            ->whenStudentCenterId(request()->student_center_id)
            ->whenStudentProjectId(request()->student_project_id)
            ->whenStudentSectionId(request()->student_section_id)
            ->whenReadingType(request()->reading_type)
            ->whenGender(request()->gender)
            ->where('type', UserTypeEnum::STUDENT);

        return DataTables::of($students)
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value']) {
                    $search = request('search')['value'];
                    $query->where(DB::raw("CONCAT(first_name, ' ', second_name)"), 'like', "%{$search}%");
                }
            })
            ->addColumn('record_select', 'admin.students.data_table.record_select')
            ->addColumn('email', function (User $student) {
                return str()->limit($student->email, 20);
            })
            ->addColumn('country', function (User $student) {
                return $student->country->name;
            })
            ->addColumn('governorate', function (User $student) {
                return $student->governorate->name;
            })
            ->addColumn('center', function (User $student) {
                return $student->studentCenter->name;
            })
            ->addColumn('project', function (User $student) {
                return $student->studentProject->name;
            })
            ->addColumn('section', function (User $student) {
                return $student->sectionAsStudent->name;
            })
            ->addColumn('reading_type', function (User $student) {
                return __('users.' . $student->reading_type);
            })
            ->editColumn('created_at', function (User $student) {
                return $student->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.students.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        $countries = Country::query()
            ->get();

        $centers = Center::query()
            ->get();

        return view('admin.students.create', compact('countries', 'centers'));

    }// end of create

    public function store(StudentRequest $request, StudentService $studentService)
    {
        $studentService->storeStudent($request);

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.students.index'),
        ]);

    }// end of store

    public function show(User $student)
    {
        $student->load(['country', 'governorate'])
            ->loadCount(['studentLogs']);

        return view('admin.students.show', compact('student'));

    }// end of show

    public function details(User $student)
    {
        $student->load(['country', 'governorate', 'studentLogs'])
            ->loadCount(['studentLogs']);;

        return view('admin.students._details', compact('student'));

    }// end of details

    public function logs(User $student)
    {
        $centers = Center::query()
            ->get();

        return view('admin.students._logs', compact('centers', 'student'));

    }// end of logs

    public function edit(User $student)
    {
        $student->load(['governorate']);

        $countries = Country::query()
            ->get();

        $governorates = $student->country->governorates;

        $centers = Center::query()
            ->get();

        $projects = $student->studentCenter->projects;

        $sections = $student->studentCenter->sections;

        return view('admin.students.edit',
            compact(
                'countries', 'governorates', 'centers', 'projects',
                'sections', 'student'
            )
        );

    }// end of edit

    public function update(StudentRequest $request, StudentService $studentService, User $student)
    {
        $studentService->updateStudent($request, $student);

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.students.index'),
        ]);

    }// end of update

    public function destroy(User $student)
    {
        $this->delete($student);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $student = User::FindOrFail($recordId);
            $this->delete($student);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(User $student)
    {
        $student->delete();

    }// end of delete

    public function impersonate(User $student)
    {
        auth()->user()->impersonate($student);

        session(['locale' => $student->locale]);

        return redirect()->route('student.home');

    }// end of impersonate

}//end of controller
