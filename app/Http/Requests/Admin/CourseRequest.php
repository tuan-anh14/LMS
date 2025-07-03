<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $course = $this->route()->parameter('course');

            $rules['image'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';

        }//end of if

        return $rules;

    }//end of rules

}//end of request
