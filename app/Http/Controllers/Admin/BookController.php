<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookRequest;
use App\Models\Book;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BookController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_books')->only(['index']);
        $this->middleware('permission:create_books')->only(['create', 'store']);
        $this->middleware('permission:update_books')->only(['edit', 'update']);
        $this->middleware('permission:delete_books')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $projects = Project::query()
            ->get();

        return view('admin.books.index', compact('projects'));

    }// end of index

    public function data()
    {
        $books = Book::query();

        return DataTables::of($books)
            ->addColumn('record_select', 'admin.books.data_table.record_select')
            ->addColumn('image', function (Book $book) {
                return view('admin.books.data_table.image', compact('book'));
            })
            ->editColumn('created_at', function (Book $book) {
                return $book->created_at->format('Y-m-d');
            })
            ->addColumn('actions', function (Book $book) {
                return view('admin.books.data_table.actions', compact('book'));
            })
            ->rawColumns(['record_select', 'image', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        $projects = Project::query()
            ->get();

        return view('admin.books.create', compact('projects'));

    }// end of create

    public function store(BookRequest $request)
    {
        $requestData = $request->validated();

        if ($request->file('image')) {
            //Storage::disk('local')->delete('public/uploads/' . $->image);
            $requestData['image'] = $request->file('image')->hashName();
            $request->file('image')->store('public/uploads');
        }

        Book::create($requestData);

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.books.index'),
        ]);

    }// end of store

    public function edit(Book $book)
    {
        $projects = Project::query()
            ->get();

        return view('admin.books.edit', compact('projects', 'book'));

    }// end of edit

    public function update(BookRequest $request, Book $book)
    {
        $requestData = $request->validated();

        if ($request->file('image')) {
            Storage::disk('local')->delete('public/uploads/' . $book->image);
            $requestData['image'] = $request->file('image')->hashName();
            $request->file('image')->store('public/uploads');
        }

        $book->update($requestData);

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.books.index'),
        ]);

    }// end of update

    public function destroy(Book $book)
    {
        $this->delete($book);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $book = Book::FindOrFail($recordId);
            $this->delete($book);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(Book $book)
    {
        $book->delete();

    }// end of delete

}//end of controller
