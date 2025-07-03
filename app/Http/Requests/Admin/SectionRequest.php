<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SectionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'center_id' => 'required|exists:centers,id',
            'project_id' => [
                'required', Rule::exists('project_center', 'project_id')->where('center_id', $this->center_id),
            ],
            'name' => 'required|unique:sections,name',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $section = $this->route()->parameter('section');

            $rules['name'] = 'required|unique:sections,id,' . $section->id;

        }//end of if

        return $rules;

    }//end of rules

}//end of request
