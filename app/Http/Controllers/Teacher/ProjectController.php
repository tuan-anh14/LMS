<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\ProjectRequest;
use App\Models\Center;
use App\Models\Project;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_projects')->only(['index']);
        $this->middleware('permission:create_projects')->only(['create', 'store']);
        $this->middleware('permission:update_projects')->only(['edit', 'update']);
        $this->middleware('permission:delete_projects')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $this->authorize('center_manager', session('selected_center'));

        return view('teacher.projects.index');

    }// end of index

    public function data()
    {
        $this->authorize('center_manager', session('selected_center'));

        $projects = Project::query()
            ->whenCenterId(session('selected_center')['id']);

        return DataTables::of($projects)
            ->addColumn('record_select', 'teacher.projects.data_table.record_select')
            ->editColumn('created_at', function (Project $project) {
                return $project->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'teacher.projects.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        $this->authorize('center_manager', session('selected_center'));

        $centers = Center::query()
            ->get();

        return view('teacher.projects.create', compact('centers'));

    }// end of create

    public function store(ProjectRequest $request)
    {
        $this->authorize('center_manager', session('selected_center'));

        $project = Project::create($request->validated());

        $project->centers()->attach($request->center_id);

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('teacher.projects.index'),
        ]);

    }// end of store

    public function sections(Project $project)
    {
        $sections = $project->sections;

        return view('teacher.projects._sections', compact('sections', 'project'));

    }// end of sections

    public function edit(Project $project)
    {
        $this->authorize('center_manager', session('selected_center'));

        return view('teacher.projects.edit', compact('project'));

    }// end of edit

    public function update(ProjectRequest $request, Project $project)
    {
        $this->authorize('center_manager', session('selected_center'));

        $project->update($request->validated());

        $project->centers()->sync($request->center_id);

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('teacher.projects.index'),
        ]);

    }// end of update

    public function destroy(Project $project)
    {
        $this->authorize('center_manager', session('selected_center'));

        $this->delete($project);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        $this->authorize('center_manager', session('selected_center'));

        foreach (json_decode(request()->record_ids) as $recordId) {

            $project = Project::FindOrFail($recordId);
            $this->delete($project);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(Project $project)
    {
        $project->delete();

    }// end of delete

}//end of controller
