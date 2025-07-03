<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\TeacherRequest;
use App\Models\Center;
use App\Models\Country;
use App\Models\Degree;
use App\Models\Section;
use App\Models\User;
use App\Services\TeacherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_teachers')->only(['index']);
        $this->middleware('permission:create_teachers')->only(['create', 'store']);
        $this->middleware('permission:update_teachers')->only(['edit', 'update']);
        $this->middleware('permission:delete_teachers')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $this->authorize('center_manager', session('selected_center'));

        $countries = Country::query()
            ->get();

        $degrees = Degree::query()
            ->get();

        $centers = Center::query()
            ->has('sections')
            ->get();

        return view('teacher.teachers.index', compact('countries', 'degrees', 'centers'));

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
            ->whenCenterIdAsTeacher(session('selected_center')['id'])
            ->where('type', UserTypeEnum::TEACHER);

        return DataTables::of($teachers)
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value']) {
                    $search = request('search')['value'];
                    $query->where(DB::raw("CONCAT(first_name, ' ', second_name)"), 'like', "%{$search}%");
                }
            })
            ->addColumn('record_select', 'teacher.teachers.data_table.record_select')
            ->addColumn('country', function (User $teacher) {
                return $teacher->country->name;
            })
            ->addColumn('governorate', function (User $teacher) {
                return $teacher->governorate->name;
            })
            ->addColumn('degree', function (User $teacher) {
                return $teacher->degree->name;
            })
            ->editColumn('created_at', function (User $teacher) {
                return $teacher->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'teacher.teachers.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();


    }// end of data

    public function create()
    {
        $this->authorize('center_manager', session('selected_center'));

        $countries = Country::query()
            ->get();

        $degrees = Degree::query()
            ->get();

        $grades = Section::query()
            ->get();

        return view('teacher.teachers.create', compact('countries', 'degrees', 'grades'));

    }// end of create

    public function store(TeacherRequest $request, TeacherService $teacherService)
    {
        $this->authorize('center_manager', session('selected_center'));

        $teacherService->storeTeacher($request);

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('teacher.teachers.index'),
        ]);

    }// end of store

    public function edit(User $teacher)
    {
        $this->authorize('center_manager', session('selected_center'));

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

        return view('teacher.teachers.edit', compact('countries', 'governorates', 'degrees', 'centers', 'grades', 'teacher'));

    }// end of edit

    public function update(TeacherRequest $request, User $teacher, TeacherService $teacherService)
    {
        $this->authorize('center_manager', session('selected_center'));

        $teacherService->updateTeacher($request, $teacher);

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('teacher.teachers.index'),
        ]);

    }// end of update

    public function destroy(User $teacher)
    {
        $this->authorize('center_manager', session('selected_center'));

        $this->delete($teacher);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        $this->authorize('center_manager', session('selected_center'));

        foreach (json_decode(request()->record_ids) as $recordId) {

            $teacher = Teacher::FindOrFail($recordId);
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

    public function switchLanguage(Request $request)
    {
        request()->validate([
            'locale' => 'required|in:' . implode(',', array_keys(config('localization.supportedLocales'))),
        ]);

        auth()->user()->update(['locale' => $request['locale']]);

        session(['locale' => $request['locale']]);

        return redirect()->back();

    }// end of switchLanguage

    public function switchCenter()
    {
        request()->validate([
            'center_id' => 'required|in:' . implode(',', auth()->user()->teacherAndManagerCenters->pluck('id')->toArray()),
        ]);

        $center = Center::findOrFail(request()->center_id);

        session(['selected_center' => $center]);

        return redirect()->route('teacher.home');

    }// end of switchCenter

    public function leaveImpersonate()
    {
        auth()->user()->leaveImpersonation();

        session(['locale' => auth()->user()->locale]);

        return redirect()->route('admin.home');

    }//end of leave impersonate

}//end of controller
