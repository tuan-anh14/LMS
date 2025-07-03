<?php

namespace App\Services;

use App\Enums\UserTypeEnum;
use App\Models\User;

class TeacherService
{
    public function storeTeacher($request)
    {
        $requestData = $request->validated();

        $requestData['password'] = bcrypt($request->password);

        $teacher = User::create($requestData);

        $this->attachTeacherRole($request, $teacher);

        $this->attachCentersAndSections($request, $teacher);

        $this->attachCentersAsManager($request, $teacher);

    }// end of storeTeacher

    public function attachTeacherRole($request, User $teacher)
    {
        $teacher->syncRoles([]);

        foreach ($request['centers'] as $center) {

            $teacher->syncRolesWithoutDetaching([UserTypeEnum::TEACHER], $center['center']);

        }//end of for each

        if (request()->is_examiner) {

            $teacher->syncRolesWithoutDetaching([UserTypeEnum::EXAMINER]);

        }//end of if

    }// end of attachTeacherRole

    public function updateTeacher($request, User $teacher)
    {
        $teacher->update($request->validated());

        $this->attachCentersAndSections($request, $teacher);

        $this->attachCentersAsManager($request, $teacher);

        $teacher->detachRole(UserTypeEnum::EXAMINER);

        if (request()->is_examiner) {

            $teacher->syncRolesWithoutDetaching([UserTypeEnum::EXAMINER]);

        }//end of if

    }// end of updateTeacher

    private function attachCentersAndSections($request, User $teacher)
    {
        $teacher->teacherCenters()->detach();

        $teacher->teacherSections()->detach();

        foreach ($request['centers'] as $center) {

            $teacher->teacherCenters()->attach($center['center']);

            foreach ($center['section_ids'] as $section) {

                $teacher->teacherSections()->attach(
                    $section,
                    [
                        'center_id' => $center['center']
                    ]
                );

            }//end of for each

        }//end of for each

    }// end of attachCentersAndGrades

    private function attachCentersAsManager($request, User $teacher)
    {
        $this->detachManagerCenters($teacher);

        if ($request->center_ids_as_manager) {

            foreach ($request->center_ids_as_manager as $centerId) {

                $teacher->syncRolesWithoutDetaching([UserTypeEnum::CENTER_MANAGER], $centerId);

            }//end of for each

            $teacher->managerCenters()->sync($request->center_ids_as_manager);

        }//end of if

    }// end of attachCentersAsManager

    public function detachManagerCenters(User $teacher)
    {
        foreach ($teacher->managerCenters as $managerCenter) {

            $teacher->managerCenters()->detach($managerCenter->id);

            $teacher->detachRole(UserTypeEnum::CENTER_MANAGER, $managerCenter->id);

        }//end of for each

    }// end of detachCenterManager

}//end of service