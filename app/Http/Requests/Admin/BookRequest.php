<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'number_of_pages' => 'required|integer',
            'image' => 'required|image',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $book = $this->route()->parameter('book');

            $rules['name'] = 'required|unique:books,id,' . $book->id;
            $rules['image'] = 'sometimes|nullable';

        }//end of if

        return $rules;

    }//end of rules

}//end of request
