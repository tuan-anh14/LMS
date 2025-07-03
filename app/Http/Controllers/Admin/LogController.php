<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LogTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Log;
use Yajra\DataTables\DataTables;

class LogController extends Controller
{
    public function index()
    {

    }// end of index

    public function data()
    {
        $logs = Log::query()
            ->with(['center', 'project', 'section', 'actionByUser'])
            ->whenStudentId(request()->student_id)
            ->whenCenterId(request()->center_id)
            ->whenProjectId(request()->project_id)
            ->whenSectionId(request()->section_id);

        return DataTables::of($logs)
            ->addColumn('record_select', 'admin.logs.data_table.record_select')
            ->editColumn('center', function (Log $log) {
                return $log->center->name;
            })
            ->editColumn('project', function (Log $log) {
                return $log->project->name;
            })
            ->editColumn('section', function (Log $log) {
                return $log->section->name;
            })
            ->editColumn('action_by_user', function (Log $log) {
                return $log->actionByUser->name . ' / ' . $log->actionByUser->email;
            })
            ->editColumn('created_at', function (Log $log) {
                return $log->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.logs.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();

    }// end of data

}//end of controller
