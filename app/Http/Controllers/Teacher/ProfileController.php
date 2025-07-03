<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\ProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('teacher.profile.edit');

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

        return redirect()->route('teacher.home');

    }// end of postChangeData

}//end of controller
