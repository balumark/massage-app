<?php

namespace App\Http\Requests\Service;

use App\Helper\ApiJsonResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ViewServiceAppointmentRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'service_id' => $this->route('service_id')
        ]);
    }

    public function rules()
    {
        return [
            'service_id' => 'required|integer|exists:services,id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return ApiJsonResponser::requestValidatorResponse($validator);
    }

    public function messages()
    {
        return [
            'service_id.required' => 'required',
            'service_id.integer' => 'integer',
            'service_id.exists' => 'not_existing_object',
        ];
    }
}
