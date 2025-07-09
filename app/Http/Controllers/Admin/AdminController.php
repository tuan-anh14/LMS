<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Country;
use App\Models\Degree;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['store', 'update', 'destroy', 'bulkDelete', 'delete']);

        $this->middleware('permission:read_admins')->only(['index']);
        $this->middleware('permission:create_admins')->only(['create', 'store']);
        $this->middleware('permission:update_admins')->only(['edit', 'update']);
        $this->middleware('permission:delete_admins')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $countries = Country::query()->get();
        $degrees = Degree::query()->get();
        $roles = Role::query()->get();

        return view('admin.admins.index', compact('countries', 'degrees', 'roles'));

    }// end of index

    public function data()
    {
        $admins = User::query()
            ->with(['country', 'governorate', 'degree', 'roles'])
            ->select([
                DB::raw("CONCAT(first_name, ' ', second_name) as full_name"),
                'users.*'
            ])
            ->whenCountryId(request()->country_id)
            ->whenGovernorateId(request()->governorate_id)
            ->whenDegreeId(request()->degree_id)
            ->whereHas('roles', function ($query) {
                if (request()->role_id) {
                    $query->where('id', request()->role_id);
                } else {
                    $query->whereIn('name', [UserTypeEnum::ADMIN, UserTypeEnum::SUPER_ADMIN]);
                }
            });

        return DataTables::of($admins)
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value']) {
                    $search = request('search')['value'];
                    $query->where(DB::raw("CONCAT(first_name, ' ', second_name)"), 'like', "%{$search}%");
                }
            })
            ->addColumn('record_select', 'admin.admins.data_table.record_select')
            ->addColumn('country', function (User $admin) {
                return $admin->country?->name;
            })
            ->addColumn('governorate', function (User $admin) {
                return $admin->governorate?->name;
            })
            ->addColumn('degree', function (User $admin) {
                return $admin->degree?->name;
            })
            ->addColumn('roles', function (User $admin) {
                return $admin->roles->pluck('display_name')->implode(', ');
            })
            ->editColumn('created_at', function (User $admin) {
                return $admin->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.admins.data_table.actions')
            ->rawColumns(['record_select', 'actions'])
            ->toJson();

    }// end of data

    public function create()
    {
        $countries = Country::query()->get();
        $degrees = Degree::query()->get();
        $roles = Role::whereIn('name', [UserTypeEnum::ADMIN, UserTypeEnum::SUPER_ADMIN])->get();

        return view('admin.admins.create', compact('countries', 'degrees', 'roles'));

    }// end of create

    public function store(AdminRequest $request)
    {
        $requestData = $request->validated();
        $requestData['password'] = Hash::make($request->password);
        $requestData['type'] = UserTypeEnum::ADMIN;

        $admin = User::create($requestData);
        
        // Gán role được chọn từ form
        if ($request->role_id) {
            $role = Role::find($request->role_id);
            if ($role) {
                $admin->attachRole($role->name);
            }
        }

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.admins.index'),
        ]);

    }// end of store

    public function edit(User $admin)
    {
        $admin->load(['governorate', 'degree']);

        $countries = Country::query()->get();
        $governorates = $admin->country?->governorates ?: collect();
        $degrees = Degree::query()->get();
        $roles = Role::whereIn('name', [UserTypeEnum::ADMIN, UserTypeEnum::SUPER_ADMIN])->get();

        return view('admin.admins.edit', compact('countries', 'governorates', 'degrees', 'admin', 'roles'));

    }// end of edit

    public function show(User $admin)
    {
        $admin->load(['governorate', 'degree']);

        return view('admin.admins.show', compact('admin'));

    }// end of show

    public function update(AdminRequest $request, User $admin)
    {
        $requestData = $request->validated();
        
        if ($request->filled('password')) {
            $requestData['password'] = Hash::make($request->password);
        } else {
            unset($requestData['password']);
        }

        $admin->update($requestData);
        
        // Cập nhật role được chọn từ form
        if ($request->role_id) {
            $role = Role::find($request->role_id);
            if ($role) {
                $admin->syncRoles([$role->name]);
            }
        }

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('admin.admins.index'),
        ]);

    }// end of update

    public function destroy(User $admin)
    {
        $this->delete($admin);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {
            $admin = User::find($recordId);
            $this->delete($admin);
        }

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(User $admin)
    {
        if ($admin->image) {
            Storage::disk('local')->delete('uploads/' . $admin->image);
        }

        $admin->delete();

    }// end of delete

    public function switchLanguage(Request $request)
    {
        $locale = $request->get('locale');
        
        if (in_array($locale, ['vi', 'en'])) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }

        return redirect()->back();

    }// end of switchLanguage

}// end of controller 