<?php

namespace App\Services;

use App\Models\StudentLecture;

class LectureService
{
    public function storeStudentLecture($request)
    {
        $studentLecture = StudentLecture::create($request->validated());

        $this->attachPagesToStudentLecture($request, $studentLecture);

    }// end of storeLectureForStudent

    public function updateStudentLecture($request, StudentLecture $studentLecture)
    {
        $studentLecture->update($request->validated());

        $this->attachPagesToStudentLecture($request, $studentLecture);

    }// end of updateLectureForStudent

    public function attachPagesToStudentLecture($request, StudentLecture $studentLecture)
    {
        $studentLecture->pages()->delete();

        if ($request->pages) {

            foreach ($request->pages as $page) {

                $studentLecture->pages()->create([
                    'student_id' => $studentLecture->student_id,
                    'lecture_id' => $studentLecture->lecture_id,
                    'center_id' => $studentLecture->center_id,
                    'section_id' => $studentLecture->section_id,
                    'teacher_id' => auth()->user()->id,
                    'book_id' => $studentLecture->book_id,
                    'assessment' => $page['assessment'],
                    'from' => $page['from'],
                    'to' => $page['to'],
                ]);

            }//end of for each

        }//end of if

    }// end of attachPagesToLecturesForStudent

}//end of service