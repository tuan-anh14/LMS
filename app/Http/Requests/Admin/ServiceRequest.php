<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'name' => 'required',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $service = $this->route()->parameter('service');

            $rules['icon'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';

        }//end of if

        return $rules;

    }//end of rules

}//end of request
