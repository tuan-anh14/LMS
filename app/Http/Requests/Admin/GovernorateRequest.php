<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GovernorateRequest extends FormRequest
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
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|unique:governorates,name',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $governorate = $this->route()->parameter('governorate');

            $rules['name'] = 'required|unique:governorates,id,' . $governorate->id;

        }//end of if

        return $rules;

    }//end of rules

}//end of request
