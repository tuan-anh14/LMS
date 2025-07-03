<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingsGeneralDataRequest;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function __construct()
    {
        //disable actions in demo mode
        $this->middleware('demo_mode_middleware')->only(['storeGeneralData']);

        $this->middleware('permission:read_settings')->only(['index', 'socialLinks', 'socialLogin']);

    }// end of __construct

    public function generalData()
    {
        return view('admin.settings.general_data');

    }// end of index

    public function storeGeneralData(SettingsGeneralDataRequest $request)
    {
        $requestData = $request->validated();

        if ($request->logo) {
            Storage::disk('local')->delete('public/uploads/' . setting('logo'));
            $request->logo->store('public/uploads');
            $requestData['logo'] = $request->logo->hashName();
        }

        if ($request->fav_icon) {
            Storage::disk('local')->delete('public/uploads/' . setting('fav_icon'));
            $request->fav_icon->store('public/uploads');
            $requestData['fav_icon'] = $request->fav_icon->hashName();
        }

        setting($requestData)->save();

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('admin.home'),
        ]);

    }// end of store


}//end of controller


