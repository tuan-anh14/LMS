<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExaminerRequest;
use App\Models\Center;
use App\Models\Country;
use App\Models\Degree;
use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ExaminerController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_examiners')->only(['index']);
        $this->middleware('permission:create_examiners')->only(['create', 'store']);
        $this->middleware('permission:update_examiners')->only(['edit', 'update']);
        $this->middleware('permission:delete_examiners')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $countries = Country::query()
            ->get();

        return view('admin.examiners.index', compact('countries'));

    }// end of index

    public function data()
    {
        $examiners = User::query()
            ->with(['country', 'governorate', 'degree'])
            ->select([
                DB::raw("CONCAT(first_name, ' ', second_name) as full_name"),
                'users.*'
            ])
            ->whenCountryId(request()->country_id)
            ->whenGovernorateId(request()->governorate_id)
            ->whenDegreeId(request()->degree_id)
            ->whereRoleIs(UserTypeEnum::EXAMINER);

        return DataTables::of($examiners)
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value']) {
                    $search = request('search')['value'];
                    $query->where(DB::raw("CONCAT(first_name, ' ', second_name)"), 'like', "%{$search}%");
                }
            })
            ->addColumn('record_select', 'admin.examiners.data_table.record_select')
            ->addColumn('country', function (User $examiner) {
                return $examiner->country->name;
            })
            ->addColumn('governorate', function (User $examiner) {
                return $examiner->governorate->name;
            })
            ->addColumn('degree', function (User $examiner) {
                return $examiner->degree->name;
            })
            ->editColumn('created_at', function (User $examiner) {
                return $examiner->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.examiners.data_table.actions')
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

        return view('admin.examiners.create', compact('countries', 'degrees', 'centers', 'grades'));

    }// end of create

    public function store(ExaminerRequest $request)
    {
        $requestData = $request->validated();

        $requestData['password'] = bcrypt($request->password);

        $examiner = User::create($requestData);

        $examiner->attachRole(UserTypeEnum::EXAMINER);

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.examiners.index'),
        ]);

    }// end of store

    public function edit(User $examiner)
    {
        $examiner->load(['governorate', 'degree', 'managerCenters']);

        $countries = Country::query()
            ->get();

        $governorates = $examiner->country->governorates;

        $degrees = Degree::query()
            ->get();

        $grades = Section::query()
            ->get();

        return view('admin.examiners.edit', compact('countries', 'governorates', 'degrees', 'grades', 'examiner'));

    }// end of edit

    public function update(ExaminerRequest $request, User $examiner)
    {
        $examiner->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.examiners.index'),
        ]);

    }// end of update

    public function destroy(User $examiner)
    {
        $this->delete($examiner);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $examiner = User::FindOrFail($recordId);
            $this->delete($examiner);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(User $examiner)
    {
        $examiner->delete();

    }// end of delete

    public function impersonate(User $examiner)
    {

        auth()->user()->impersonate($examiner);

        session(['locale' => $examiner->locale]);
        //dd(session());
        return redirect()->route('examiner.home');

    }// end of impersonate

}//end of controller
