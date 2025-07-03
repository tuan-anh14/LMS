<?php

namespace App\Http\Controllers\Examiner;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StudentRequest;
use App\Models\Center;
use App\Models\Country;
use App\Models\User;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_students')->only(['index']);
        $this->middleware('permission:create_students')->only(['create', 'store']);
        $this->middleware('permission:update_students')->only(['edit', 'update']);
        $this->middleware('permission:delete_students')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $countries = Country::query()
            ->get();

        $sections = auth()->user()->hasRole('center_manager')
            ? session('selected_center')->sections
            : auth()->user()->teacherSections()->wherePivot('center_id', session('selected_center')['id'])
                ->get();

        return view('teacher.students.index', compact('countries', 'sections'));

    }// end of index

    public function data()
    {
        $authIsCenterManager = auth()->user()->hasRole('center_manager');

        $students = User::query()
            ->with(['country', 'governorate', 'degree'])
            ->whenStudentCenterId(session('selected_center')['id'])
            ->whenCountryId(request()->country_id)
            ->whenGovernorateId(request()->governorate_id)
            ->whenStudentSectionIds(
                $authIsCenterManager
                    ? session('selected_center')->sections->pluck('id')->toArray()
                    : auth()->user()->teacherSections()->wherePivot('center_id', session('selected_center')['id'])
                    ->pluck('section_id')
                    ->toArray()
            )
            ->whenStudentSectionId(request()->section_id)
            ->whenGender(
                auth()->user()->hasRole('center_manager', session('selected_center')['id'])
                    ? request()->gender
                    : auth()->user()->gender
            )
            ->where('type', UserTypeEnum::STUDENT);

        return DataTables::of($students)
            ->addColumn('record_select', 'admin.students.data_table.record_select')
            ->addColumn('country', function (User $student) {
                return $student->country->name;
            })
            ->addColumn('governorate', function (User $student) {
                return $student->governorate->name;
            })
            ->addColumn('section', function (User $student) {
                return $student->studentSection->name;
            })
            ->addColumn('full_name', function (User $student) {
                return $student->full_name; // Use the accessor here
            })
            ->editColumn('created_at', function (User $student) {
                return $student->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'teacher.students.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        $this->authorize('center_manager', session('selected_center'));

        $countries = Country::query()
            ->get();

        $projects = session('selected_center')->projects;

        return view('teacher.students.create', compact('countries', 'projects'));

    }// end of create

    public function store(StudentRequest $request)
    {
        $this->authorize('center_manager', session('selected_center'));

        $requestData = $request->validated();

        $requestData['password'] = bcrypt($request->password);

        $student = User::create($requestData);

        $student->attachRole(UserTypeEnum::STUDENT);

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('teacher.students.index'),
        ]);

    }// end of store

    public function show(User $student)
    {
        $student->load(['country', 'governorate'])
            ->loadCount(['studentLogs']);

        return view('teacher.students.show', compact('student'));

    }// end of show

    public function details(User $student)
    {
        $student->load(['country', 'governorate', 'studentLogs'])
            ->loadCount(['studentLogs']);;

        return view('teacher.students._details', compact('student'));

    }// end of details

    public function lectures(User $student)
    {
        return view('teacher.students._lectures', compact('student'));

    }// end of lectures

    public function pages(User $student)
    {
        $authIssCenterManager = auth()->user()->hasRole('center_manager');

        $lectures = $authIssCenterManager
            ? session('selected_center')->lectures
            : auth()->user()->teacherSections()->wherePivot('center_id', session('selected_center')['id'])
                ->get();

        return view('teacher.students._pages', compact('lectures', 'student'));

    }// end of pages

    public function exams(User $student)
    {
        $projects = $student->studentCenter->projects;

        return view('teacher.students._exams', compact('student', 'projects'));

    }// end of exams

    public function logs(User $student)
    {
        $centers = Center::query()
            ->get();

        return view('teacher.students._logs', compact('centers', 'student'));

    }// end of logs

    public function edit(User $student)
    {
        $student->load(['governorate']);

        $countries = Country::query()
            ->get();

        $governorates = $student->country->governorates;

        $projects = session('selected_center')->projects;

        $sections = $student->studentCenter->sections;

        return view('teacher.students.edit', compact('countries', 'governorates', 'projects', 'sections', 'student'));

    }// end of edit

    public function update(StudentRequest $request, User $student)
    {
        $student->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('teacher.students.index'),
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

            $student = Teacher::FindOrFail($recordId);
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


}//end of controller
