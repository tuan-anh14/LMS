<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CenterRequest;
use App\Models\Center;
use Yajra\DataTables\DataTables;

class CenterController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_centers')->only(['index']);
        $this->middleware('permission:create_centers')->only(['create', 'store']);
        $this->middleware('permission:update_centers')->only(['edit', 'update']);
        $this->middleware('permission:delete_centers')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        return view('admin.centers.index');

    }// end of index

    public function data()
    {
        $centers = Center::query()
            ->with(['managers'])
            ->withCount(['projects', 'sections']);

        return DataTables::of($centers)
            ->addColumn('record_select', 'admin.centers.data_table.record_select')
            ->addColumn('managers', function (Center $center) {
                return view('admin.centers.data_table.managers', compact('center'));
            })
            ->editColumn('created_at', function (Center $center) {
                return $center->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.centers.data_table.actions')
            ->rawColumns(['record_select', 'managers', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        return view('admin.centers.create');

    }// end of create

    public function store(CenterRequest $request)
    {
        Center::create($request->validated());

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.centers.index'),
        ]);

    }// end of store

    public function projects(Center $center)
    {
        $projects = $center->projects;

        return view('admin.centers._projects', compact('projects', 'center'));

    }// end of projects

    public function edit(Center $center)
    {
        return view('admin.centers.edit', compact('center'));

    }// end of edit

    public function update(CenterRequest $request, Center $center)
    {
        $center->update($request->validated());

        $center->managers()->sync($request->manager_ids);

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.centers.index'),
        ]);

    }// end of update

    public function destroy(Center $center)
    {
        $this->delete($center);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $center = Center::FindOrFail($recordId);
            $this->delete($center);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(Center $center)
    {
        $center->delete();

    }// end of delete

}//end of controller
