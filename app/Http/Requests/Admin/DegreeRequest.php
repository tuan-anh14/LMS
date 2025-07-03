<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DegreeRequest extends FormRequest
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
            'name' => 'required|unique:degrees,name',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $degree = $this->route()->parameter('degree');

            $rules['name'] = 'required|unique:degrees,id,' . $degree->id;

        }//end of if

        return $rules;

    }//end of rules

}//end of request
