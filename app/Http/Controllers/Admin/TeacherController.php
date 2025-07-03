<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherRequest;
use App\Models\Center;
use App\Models\Country;
use App\Models\Degree;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\User;
use App\Services\TeacherService;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TeacherController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_teachers')->only(['index']);
        $this->middleware('permission:create_teachers')->only(['create', 'store']);
        $this->middleware('permission:update_teachers')->only(['edit', 'update']);
        $this->middleware('permission:delete_teachers')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $countries = Country::query()
            ->get();

        $degrees = Degree::query()
            ->get();

        $centers = Center::query()
            ->has('sections')
            ->get();

        return view('admin.teachers.index', compact('countries', 'degrees', 'centers'));

    }// end of index

    public function data()
    {
        $teachers = User::query()
            ->with(['country', 'governorate', 'degree'])
            ->select([
                DB::raw("CONCAT(first_name, ' ', second_name) as full_name"),
                'users.*'
            ])
            ->whenCountryId(request()->country_id)
            ->whenGovernorateId(request()->governorate_id)
            ->whenDegreeId(request()->degree_id)
            ->whenCenterIdAsTeacher(request()->center_id)
            ->whereHas('roles', function ($query) {
                $query->where('name', UserTypeEnum::TEACHER);
            })
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', UserTypeEnum::SUPER_ADMIN);
            });

        return DataTables::of($teachers)
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value']) {
                    $search = request('search')['value'];
                    $query->where(DB::raw("CONCAT(first_name, ' ', second_name)"), 'like', "%{$search}%");
                }
            })
            ->addColumn('record_select', 'admin.teachers.data_table.record_select')
            ->addColumn('country', function (User $teacher) {
                return $teacher->country?->name;
            })
            ->addColumn('governorate', function (User $teacher) {
                return $teacher->governorate?->name;
            })
            ->addColumn('degree', function (User $teacher) {
                return $teacher->degree?->name;
            })
            ->editColumn('created_at', function (User $teacher) {
                return $teacher->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.teachers.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();


    }// end of data

    public function create()
    {
        $countries = Country::query()
            ->get();

        $degrees = Degree::query()
            ->get();

        $centers = Center::query()
            ->with(['sections'])
            ->has('sections')
            ->get();

        $grades = Section::query()
            ->get();

        return view('admin.teachers.create', compact('countries', 'degrees', 'centers', 'grades'));

    }// end of create

    public function store(TeacherRequest $request, TeacherService $teacherService)
    {
        $teacherService->storeTeacher($request);

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.teachers.index'),
        ]);

    }// end of store

    public function edit(User $teacher)
    {
        $teacher->load(['governorate', 'degree', 'teacherCenters', 'managerCenters']);

        $countries = Country::query()
            ->get();

        $governorates = $teacher->country->governorates;

        $degrees = Degree::query()
            ->get();

        $centers = Center::query()
            ->has('sections')
            ->get();

        $grades = Section::query()
            ->get();

        return view('admin.teachers.edit', compact('countries', 'governorates', 'degrees', 'centers', 'grades', 'teacher'));

    }// end of edit

    public function show(User $teacher)
    {
        $teacher->load(['governorate', 'degree', 'teacherCenters', 'managerCenters']);

        return view('admin.teachers.show', compact('teacher'));

    }// end of show

    public function details(User $teacher)
    {
        $teacher->load(['governorate', 'degree', 'teacherCenters', 'managerCenters']);

        return view('admin.teachers._details', compact('teacher'));

    }// end of details

    public function studentLectures(User $teacher)
    {
        $teacher->load(['governorate', 'degree', 'teacherCenters', 'managerCenters']);

        $centers = $teacher->teacherCenters;

        return view('admin.teachers._student_lectures', compact('centers', 'teacher'));

    }// end of studentLectures

    public function update(TeacherRequest $request, User $teacher, TeacherService $teacherService)
    {
        $teacherService->updateTeacher($request, $teacher);

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.teachers.index'),
        ]);

    }// end of update

    public function destroy(User $teacher)
    {
        $this->delete($teacher);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $teacher = User::FindOrFail($recordId);
            $this->delete($teacher);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(User $teacher)
    {
        $teacher->delete();

    }// end of delete

    public function impersonate(User $teacher)
    {
        auth()->user()->impersonate($teacher);

        session(['locale' => $teacher->locale]);

        return redirect()->route('teacher.home');

    }// end of impersonate

}//end of controller
