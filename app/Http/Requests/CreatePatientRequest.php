<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'min:2',
                'max:50',
            ],
            'last_name' => [
                'required',
                'string',
                'min:2',
                'max:50',
            ],
            'birthdate' => [
                'required',
                'string',
                'date:d-m-Y',
            ],
        ];
    }
}
