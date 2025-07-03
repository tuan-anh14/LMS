<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryRequest;
use App\Models\Country;
use Yajra\DataTables\DataTables;

class CountryController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_countries')->only(['index']);
        $this->middleware('permission:create_countries')->only(['create', 'store']);
        $this->middleware('permission:update_countries')->only(['edit', 'update']);
        $this->middleware('permission:delete_countries')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        return view('admin.countries.index');

    }// end of index

    public function data()
    {
        $countries = Country::query()
            ->withCount(['governorates', 'teachers', 'students']);

        return DataTables::of($countries)
            ->addColumn('record_select', 'admin.countries.data_table.record_select')
            ->editColumn('created_at', function (Country $country) {
                return $country->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.countries.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();


    }// end of data

    public function create()
    {
        return view('admin.countries.create');

    }// end of create

    public function store(CountryRequest $request)
    {
        $country = Country::create($request->validated());

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.countries.index'),
        ]);

    }// end of store

    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));

    }// end of edit

    public function update(CountryRequest $request, Country $country)
    {
        $country->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.countries.index'),
        ]);

    }// end of update

    public function governorates(Country $country)
    {
        $governorates = $country->governorates;

        return view('admin.countries._governorates', compact('governorates', 'country'));

    }// end of governorates

    public function destroy(Country $country)
    {
        $this->delete($country);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $country = Country::FindOrFail($recordId);
            $this->delete($country);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(Country $country)
    {
        $country->delete();

    }// end of delete

}//end of controller
