<?php

namespace App\Http\Requests\Examiner;

use App\Enums\AssessmentEnum;
use App\Enums\StudentExamStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class StudentExamAssessmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'assessment' => 'required|in:' . implode(',', AssessmentEnum::getConstants()),
            'status' => 'required',
            'notes' => 'sometimes|nullable|string|max:255',
        ];

        return $rules;

    }//end of rules

    public function prepareForValidation()
    {
        return $this->merge([
            'status' => StudentExamStatusEnum::ASSESSMENT_ADDED,
        ]);

    }// end of prepareForValidation

}//end of request
