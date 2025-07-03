<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Book;
use App\Models\Center;
use App\Models\Project;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_projects')->only(['index']);
        $this->middleware('permission:create_projects')->only(['create', 'store']);
        $this->middleware('permission:update_projects')->only(['edit', 'update']);
        $this->middleware('permission:delete_projects')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        return view('admin.projects.index');

    }// end of index

    public function data()
    {
        $projects = Project::query()
            ->with(['centers']);

        return DataTables::of($projects)
            ->addColumn('record_select', 'admin.projects.data_table.record_select')
            ->addColumn('centers', function (Project $project) {
                return view('admin.projects.data_table.centers', compact('project'));
            })
            ->addColumn('book', function (Project $project) {
                return $project->book->name;
            })
            ->editColumn('created_at', function (Project $project) {
                return $project->created_at->format('Y-m-d');
            })
            ->addColumn('actions', function (Project $project) {
                return view('admin.projects.data_table.actions', compact('project'));
            })
            ->rawColumns(['record_select', 'managers', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        $centers = Center::query()
            ->get();

        $books = Book::query()
            ->get();

        return view('admin.projects.create', compact('books', 'centers'));

    }// end of create

    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->validated());

        $project->centers()->sync($request->center_ids);

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.projects.index'),
        ]);

    }// end of store

    public function edit(Project $project)
    {
        $project->load('centers');

        $centers = Center::query()
            ->get();

        $books = Book::query()
            ->get();

        return view('admin.projects.edit', compact('centers', 'books', 'project'));

    }// end of edit

    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        $project->centers()->sync($request->center_ids);

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.projects.index'),
        ]);

    }// end of update

    public function sections(Project $project)
    {
        $sections = $project->sections;

        return view('admin.projects._sections', compact('sections', 'project'));

    }// end of sections

    public function destroy(Project $project)
    {
        $this->delete($project);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
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
