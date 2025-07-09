<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExamRequest;
use App\Models\Exam;
use App\Models\Project;
use Yajra\DataTables\DataTables;

class ExamController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_exams')->only(['index']);
        $this->middleware('permission:create_exams')->only(['create', 'store']);
        $this->middleware('permission:update_exams')->only(['edit', 'update']);
        $this->middleware('permission:delete_exams')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $projects = Project::query()->get();

        return view('admin.exams.index', compact('projects'));

    }// end of index

    public function data()
    {
        $exams = Exam::query()
            ->with(['project'])
            ->whenProjectId(request()->project_id);

        return DataTables::of($exams)
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value']) {
                    $search = request('search')['value'];
                    $query->where('name', 'like', "%{$search}%");
                }
            })
            ->addColumn('record_select', 'admin.exams.data_table.record_select')
            ->addColumn('project', function (Exam $exam) {
                return $exam->project->name;
            })
            ->editColumn('created_at', function (Exam $exam) {
                return $exam->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.exams.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        $projects = Project::query()->get();

        return view('admin.exams.create', compact('projects'));

    }// end of create

    public function store(ExamRequest $request)
    {
        Exam::create($request->validated());

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.exams.index'),
        ]);

    }// end of store

    public function show(Exam $exam)
    {
        $exam->load(['project']);

        return view('admin.exams.show', compact('exam'));

    }// end of show

    public function edit(Exam $exam)
    {
        $exam->load(['project']);

        $projects = Project::query()->get();

        return view('admin.exams.edit', compact('exam', 'projects'));

    }// end of edit

    public function update(ExamRequest $request, Exam $exam)
    {
        $exam->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.exams.index'),
        ]);

    }// end of update

    public function destroy(Exam $exam)
    {
        $this->delete($exam);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $exam = Exam::findOrFail($recordId);
            $this->delete($exam);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(Exam $exam)
    {
        $exam->delete();

    }// end of delete

}//end of controller 