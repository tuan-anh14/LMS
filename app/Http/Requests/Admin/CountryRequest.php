<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
            'name' => 'required|unique:countries,name',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $country = $this->route()->parameter('country');

            $rules['name'] = 'required|unique:countries,id,' . $country->id;

        }//end of if

        return $rules;

    }//end of rules

}//end of request
