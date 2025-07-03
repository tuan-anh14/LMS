<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DegreeRequest;
use App\Models\Country;
use App\Models\Degree;
use Yajra\DataTables\DataTables;

class DegreeController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_degrees')->only(['index']);
        $this->middleware('permission:create_degrees')->only(['create', 'store']);
        $this->middleware('permission:update_degrees')->only(['edit', 'update']);
        $this->middleware('permission:delete_degrees')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        return view('admin.degrees.index');

    }// end of index

    public function data()
    {
        $degrees = Degree::query()
            ->withCount(['teachers']);

        return DataTables::of($degrees)
            ->addColumn('record_select', 'admin.degrees.data_table.record_select')
            ->editColumn('created_at', function (Degree $degree) {
                return $degree->created_at->format('Y-m-d');
            })
            ->addColumn('actions', function (Degree $degree) {
                return view('admin.degrees.data_table.actions', compact('degree'));
            })
            ->rawColumns(['record_select', 'actions'])
            ->toJson();


    }// end of data

    public function create()
    {
        $countries = Country::query()
            ->get();

        return view('admin.degrees.create', compact('countries'));

    }// end of create

    public function store(DegreeRequest $request)
    {
        Degree::create($request->validated());

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.degrees.index'),
        ]);

    }// end of store

    public function edit(Degree $degree)
    {
        return view('admin.degrees.edit', compact('degree'));

    }// end of edit

    public function update(DegreeRequest $request, Degree $degree)
    {
        $degree->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.degrees.index'),
        ]);

    }// end of update

    public function destroy(Degree $degree)
    {
        $this->delete($degree);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $degree = Degree::FindOrFail($recordId);
            $this->delete($degree);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(Degree $degree)
    {
        $degree->delete();

    }// end of delete

}//end of controller
