<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GovernorateRequest;
use App\Models\Country;
use App\Models\Governorate;
use Yajra\DataTables\DataTables;

class GovernorateController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_governorates')->only(['index']);
        $this->middleware('permission:create_governorates')->only(['create', 'store']);
        $this->middleware('permission:update_governorates')->only(['edit', 'update']);
        $this->middleware('permission:delete_governorates')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $countries = Country::query()
            ->get();

        return view('admin.governorates.index', compact('countries'));

    }// end of index

    public function data()
    {
        $governorate = Governorate::query()
            ->with(['country'])
            ->withCount(['teachers', 'students']);

        return DataTables::of($governorate)
            ->addColumn('record_select', 'admin.governorates.data_table.record_select')
            ->editColumn('created_at', function (Governorate $governorate) {
                return $governorate->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.governorates.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        $countries = Country::query()
            ->get();

        return view('admin.governorates.create', compact('countries'));

    }// end of create

    public function store(GovernorateRequest $request)
    {
        Governorate::create($request->validated());

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.governorates.index'),
        ]);

    }// end of store

    public function edit(Governorate $governorate)
    {
        $countries = Country::query()
            ->get();

        return view('admin.governorates.edit', compact('countries', 'governorate'));

    }// end of edit

    public function update(GovernorateRequest $request, Governorate $governorate)
    {
        $governorate->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.governorates.index'),
        ]);

    }// end of update

    public function areas(Governorate $governorate)
    {

        return view('admin.governorates._areas', compact('governorate'));

    }// end of areas

    public function destroy(Governorate $governorate)
    {
        $this->delete($governorate);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $governorate = Governorate::FindOrFail($recordId);
            $this->delete($governorate);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(Governorate $governorate)
    {
        $governorate->delete();

    }// end of delete

}//end of controller
