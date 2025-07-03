<?php

namespace App\Http\Requests\Examiner;

use App\Enums\LectureTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LectureRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'center_id' => 'required',
            'section_id' => [
                'required',
                Rule::exists('teacher_center_section', 'section_id')
                    ->where('center_id', session('selected_center')['id']),
            ],
            'teacher_id' => 'required',
            'type' => 'required|in:' . implode(',', LectureTypeEnum::getConstants()),
            'date' => 'required|date',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $lecture = $this->route()->parameter('lecture');

        }//end of if

        return $rules;

    }//end of rules

    public function prepareForValidation()
    {
        return $this->merge([
            'center_id' => session('selected_center')['id'],
            'teacher_id' => auth()->user()->id,
        ]);

    }// end of prepareForValidation

}//end of request
