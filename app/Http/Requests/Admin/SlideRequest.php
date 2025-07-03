<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'upper_title' => 'required',
            'link' => 'required|url',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $slide = $this->route()->parameter('slide');

            $rules['image'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';

        }//end of if

        return $rules;

    }//end of rules

}//end of request
