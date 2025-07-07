<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'first_name' => 'required',
            'second_name' => 'required',
            'nickname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'type' => 'required',
            'role_id' => 'required|exists:roles,id',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $admin = $this->route()->parameter('admin');

            $rules['email'] = 'required|email|unique:users,id,' . $admin->id;
            $rules['password'] = '';

        }//end of if

        return $rules;

    }//end of rules

    protected function prepareForValidation()
    {
        return $this->merge([
            'type' => 'admin'
        ]);

    }//end of prepare for validation

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->role_id) {
                $role = Role::find($this->role_id);
                if ($role && !in_array($role->name, ['admin', 'super_admin'])) {
                    $validator->errors()->add('role_id', 'Chỉ được phép chọn role admin hoặc super_admin.');
                }
            }
        });
    }

}//end of request
