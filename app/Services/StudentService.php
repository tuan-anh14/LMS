<?php

namespace App\Services;

use App\Enums\UserTypeEnum;
use App\Models\User;

class StudentService
{
    public function storeStudent($request)
    {
        $requestData = $request->validated();

        $requestData['password'] = bcrypt($request->password);

        if ($request->file('image')) {
            $requestData['image'] = $request->file('image')->hashName();
            $request->file('image')->store('public/uploads');
        }

        $student = User::create($requestData);

        $student->attachRole(UserTypeEnum::STUDENT);

        // $student->sectionsAsStudent()->create([
        //     'center_id' => $student->student_center_id,
        //     'section_id' => $student->student_section_id,
        // ]);

        $this->storeStudentLogs($student);

    }// end of storeStudent

    public function updateStudent($request, User $student)
    {
        $requestData = $request->validated();

        if ($request->file('image')) {
            $requestData['image'] = $request->file('image')->hashName();
            $request->file('image')->store('public/uploads');
        }

        $student->update($requestData);

        $this->storeStudentLogs($student);

    }// end of updateStudent

    public function storeStudentLogs(User $student)
    {
        $student->studentLogs()->create([
            'center_id' => $student->student_center_id,
            'project_id' => $student->student_project_id,
            'section_id' => $student->student_section_id,
            'action_by_user_id' => auth()->user() ? auth()->user()->id : User::FindOrFail(1)->id,
        ]);

    }// end of storeStudentLogs

}//end of service