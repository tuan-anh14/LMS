<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('student.profile.edit');

    }// end of getChangeData

    public function update(ProfileRequest $request)
    {
        $requestData = $request->validated();

        if ($request->image) {
            $requestData['image'] = $request->image->hashName();
            $request->image->store('public/uploads');
        }
        
        auth()->user()->update($requestData);

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('student.home'),
        ]);

    }// end of postChangeData

    public function switchLanguage($locale)
    {
        $supported = array_keys(config('localization.supportedLocales'));
        if (!in_array($locale, $supported)) {
            abort(404);
        }
        auth()->user()->update(['locale' => $locale]);
        session(['locale' => $locale]);
        return redirect()->back();
    }

}//end of controller
