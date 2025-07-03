<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\SectionRequest;
use App\Models\Project;
use App\Models\Section;
use Yajra\DataTables\DataTables;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_sections')->only(['index']);
        $this->middleware('permission:create_sections')->only(['create', 'store']);
        $this->middleware('permission:update_sections')->only(['edit', 'update']);
        $this->middleware('permission:delete_sections')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $projects = Project::query()
            ->whenCenterId(session('selected_center')['id'])
            ->get();

        return view('teacher.sections.index', compact('projects'));

    }// end of index

    public function data()
    {
        $sections = Section::query()
            ->with('center', 'project')
            ->whenCenterId(session('selected_center')['id'])
            ->whenProjectId(request()->input('project_id'));

        return DataTables::of($sections)
            ->addColumn('record_select', 'teacher.sections.data_table.record_select')
            ->addColumn('center', function (Section $section) {
                return $section->center->name;
            })
            ->addColumn('project', function (Section $section) {
                return $section->project->name;
            })
            ->editColumn('created_at', function (Section $section) {
                return $section->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'teacher.sections.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        $this->authorize('center_manager', session('selected_center'));

        $projects = Project::query()
            ->whenCenterId(session('selected_center')['id'])
            ->get();

        return view('teacher.sections.create', compact('projects'));

    }// end of create

    public function store(SectionRequest $request)
    {
        $this->authorize('center_manager', session('selected_center'));

        Section::create($request->validated());

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('teacher.sections.index'),
        ]);

    }// end of store

    public function edit(Section $section)
    {
        $this->authorize('center_manager', session('selected_center'));

        $projects = Project::query()
            ->whenCenterId(session('selected_center')['id'])
            ->get();

        return view('teacher.sections.edit', compact('projects', 'section'));

    }// end of edit

    public function update(SectionRequest $request, Section $section)
    {
        $this->authorize('center_manager', session('selected_center'));

        $section->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('teacher.sections.index'),
        ]);

    }// end of update

    public function lectureTypes(Section $section)
    {
        $section->load('project');

        return view('teacher.sections._lecture_types', compact('section'));

    }// end of lectureTypes

    public function destroy(Section $section)
    {
        $this->authorize('center_manager', session('selected_center'));

        $this->delete($section);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        $this->authorize('center_manager', session('selected_center'));

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
