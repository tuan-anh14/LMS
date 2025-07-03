<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SlideRequest;
use App\Models\Slide;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class SlideController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_slides')->only(['index']);
        $this->middleware('permission:create_slides')->only(['create', 'store']);
        $this->middleware('permission:update_slides')->only(['edit', 'update']);
        $this->middleware('permission:delete_slides')->only(['delete', 'bulk_delete']);


    }// end of __construct

    public function index()
    {
        return view('admin.slides.index');

    }// end of index

    public function data()
    {
        $slides = Slide::query();

        return DataTables::of($slides)
            ->addColumn('record_select', 'admin.slides.data_table.record_select')
            ->addColumn('image', function (Slide $slide) {
                return view('admin.slides.data_table.image', compact('slide'));
            })
            ->editColumn('created_at', function (Slide $slide) {
                return $slide->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.slides.data_table.actions')
            ->rawColumns(['record_select', 'image', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        return view('admin.slides.create');

    }// end of create

    public function store(SlideRequest $request)
    {
        $requestData = $request->validated();

        if ($request->file('image')) {
            $requestData['image'] = $request->file('image')->hashName();
            $request->file('image')->store('public/uploads');
        }

        Slide::create($requestData);

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.slides.index'),
        ]);

    }// end of store

    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', compact('slide'));

    }// end of edit

    public function update(SlideRequest $request, Slide $slide)
    {
        $requestData = $request->validated();

        if ($request->file('image')) {
            Storage::disk('local')->delete('public/uploads/' . $slide->image);
            $requestData['image'] = $request->file('image')->hashName();
            $request->file('image')->store('public/uploads');
        }

        $slide->update($requestData);

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.slides.index'),
        ]);

    }// end of update

    public function destroy(Slide $slide)
    {
        $this->delete($slide);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $slide = Slide::FindOrFail($recordId);
            $this->delete($slide);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(Slide $slide)
    {
        $slide->delete();

    }// end of delete

}//end of controller
