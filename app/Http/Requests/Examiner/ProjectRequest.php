<?php

namespace App\Http\Requests\Examiner;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'center_id' => 'required|exists:centers,id',
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
            'center_id' => session('selected_center')['id'],
        ]);

    }//end of prepare for validation

}//end of request
