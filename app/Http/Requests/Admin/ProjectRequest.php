<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
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
            'book_id' => 'required|exists:books,id',
            'center_ids' => 'required|array',
            'center_ids.*' => 'required|exists:centers,id',
            'has_tajweed_lectures' => 'required|boolean',
            'has_upbringing_lectures' => 'required|boolean',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $project = $this->route('project');

            $rules['name'] = 'required|unique:projects,name,' . $project->id;

        }//end of if

        return $rules;

    }//end of rules

    protected function prepareForValidation()
    {
        return $this->merge([
            'has_tajweed_lectures' => $this->has_tajweed_lectures ? true : false,
            'has_upbringing_lectures' => $this->has_upbringing_lectures ? true : false,
        ]);

    }//end of prepare for validation

}//end of request
