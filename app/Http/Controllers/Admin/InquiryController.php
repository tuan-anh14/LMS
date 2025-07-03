<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InquiryRequest;
use App\Models\Inquiry;
use Yajra\DataTables\DataTables;

class InquiryController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_inquiries')->only(['index']);
        $this->middleware('permission:delete_inquiries')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        return view('admin.inquiries.index');

    }// end of index

    public function data()
    {
        $inquiries = Inquiry::query();

        return DataTables::of($inquiries)
            ->addColumn('record_select', 'admin.inquiries.data_table.record_select')
            ->editColumn('created_at', function (Inquiry $inquiry) {
                return $inquiry->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.inquiries.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();

    }// end of data

    public function show(Inquiry $inquiry)
    {
        return view('admin.inquiries.show', compact('inquiry'));

    }// end of show

    public function destroy(Inquiry $inquiry)
    {
        $this->delete($inquiry);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $inquiry = Inquiry::FindOrFail($recordId);

            $this->delete($inquiry);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(Inquiry $inquiry)
    {
        $inquiry->delete();

    }// end of delete

}//end of controller
