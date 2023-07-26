<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'birthdate' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female',
            'phone' => 'required|string|regex:/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/',
            'password' => 'nullable',
            'roles' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'gender.in' => "The gender must be male or female.",
            'phone.regex' => "The phone format must be +7(xxx)xxx-xx-xx.",
        ];
    }
}
