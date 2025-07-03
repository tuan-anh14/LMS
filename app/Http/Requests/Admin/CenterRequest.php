<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CenterRequest extends FormRequest
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
            'name' => 'required|unique:centers,name',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $center = $this->route()->parameter('center');

            $rules['name'] = 'required|unique:centers,id,' . $center->id;

        }//end of if

        return $rules;

    }//end of rules

    protected function prepareForValidation()
    {
        return $this->merge([
            'type' => 'admin'
        ]);

    }//end of prepare for validation

}//end of request
