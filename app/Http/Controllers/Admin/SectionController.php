<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SectionRequest;
use App\Models\Center;
use App\Models\Section;
use Yajra\DataTables\DataTables;

class SectionController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_sections')->only(['index']);
        $this->middleware('permission:create_sections')->only(['create', 'store']);
        $this->middleware('permission:update_sections')->only(['edit', 'update']);
        $this->middleware('permission:delete_sections')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $centers = Center::query()
            ->get();

        return view('admin.sections.index', compact('centers'));

    }// end of index

    public function data()
    {
        $sections = Section::query()
            ->with('center', 'project')
            ->whenCenterId(request()->input('center_id'))
            ->whenProjectId(request()->input('project_id'));

        return DataTables::of($sections)
            ->addColumn('record_select', 'admin.sections.data_table.record_select')
            ->addColumn('center', function (Section $section) {
                return $section->center->name;
            })
            ->addColumn('project', function (Section $section) {
                return $section->project->name;
            })
            ->editColumn('created_at', function (Section $section) {
                return $section->created_at->format('Y-m-d');
            })
            ->addColumn('actions', function (Section $section) {
                return view('admin.sections.data_table.actions', compact('section'));
            })
            ->rawColumns(['record_select', 'managers', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        $centers = Center::query()
            ->get();

        return view('admin.sections.create', compact('centers'));

    }// end of create

    public function store(SectionRequest $request)
    {
        Section::create($request->validated());

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.sections.index'),
        ]);

    }// end of store

    public function edit(Section $section)
    {
        $centers = Center::query()
            ->get();

        $projects = $section->center->projects;

        return view('admin.sections.edit', compact('centers', 'projects', 'section'));

    }// end of edit

    public function update(SectionRequest $request, Section $section)
    {
        $section->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.sections.index'),
        ]);

    }// end of update

    public function destroy(Section $section)
    {
        $this->delete($section);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $section = Section::FindOrFail($recordId);
            $this->delete($section);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(Section $section)
    {
        $section->delete();

    }// end of delete

}//end of controller
