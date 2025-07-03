<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ServiceController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_services')->only(['index']);
        $this->middleware('permission:create_services')->only(['create', 'store']);
        $this->middleware('permission:update_services')->only(['edit', 'update']);
        $this->middleware('permission:delete_services')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        return view('admin.services.index');

    }// end of index

    public function data()
    {
        $services = Service::query();

        return DataTables::of($services)
            ->addColumn('record_select', 'admin.services.data_table.record_select')
            ->addColumn('icon', function (Service $service) {
                return view('admin.services.data_table.icon', compact('service'));
            })
            ->editColumn('created_at', function (Service $service) {
                return $service->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.services.data_table.actions')
            ->rawColumns(['record_select', 'icon', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        return view('admin.services.create');

    }// end of create

    public function store(ServiceRequest $request)
    {
        $requestData = $request->validated();

        if ($request->file('icon')) {
            $requestData['icon'] = $request->file('icon')->hashName();
            $request->file('icon')->store('public/uploads');
        }

        Service::create($requestData);

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.services.index'),
        ]);

    }// end of store

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));

    }// end of edit

    public function update(ServiceRequest $request, Service $service)
    {
        $requestData = $request->validated();

        if ($request->file('icon')) {
            Storage::disk('local')->delete('public/uploads/' . $service->icon);
            $requestData['icon'] = $request->file('icon')->hashName();
            $request->file('icon')->store('public/uploads');
        }

        $service->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.services.index'),
        ]);

    }// end of update

    public function destroy(Service $service)
    {
        $this->delete($service);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $service = Service::FindOrFail($recordId);
            $this->delete($service);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(Service $service)
    {
        $service->delete();

    }// end of delete

}//end of controller
