<?php

namespace App\Http\Requests\Auth;

use App\Helper\ApiJsonResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            
        ]);
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|min:8',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return ApiJsonResponser::requestValidatorResponse($validator);
    }

    public function messages()
    {
        return [
            'name.required' => 'required',
            'name.string' => 'string',
            'email,required' => 'required',
            'email.string' => 'string',
            'email.email' => 'email',
            'email.unique' => 'unique:users,email',
            'password.required' => 'required',
            'password.min' => 'min:8',
        ];
    }
}
