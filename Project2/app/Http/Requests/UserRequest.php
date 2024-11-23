<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('user.id') ?? null;
        
        return [
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => $this->isMethod('POST') ? 'required|min:6' : 'nullable|min:6',
            'name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z\s]+$/',
                'not_regex:/[0-9]/',
                'min:2',
                'max:255'
            ],
            'id_number' => [
                'required',
                'numeric',
                'digits_between:1,20',
            ],
            'address' => 'required|string|max:255',
            'role' => 'required|in:1,2',
            'status' => 'required|numeric',
            'gender' => 'required|in:male,female',
            'phone' => [
                'required',
                'numeric',
                'digits_between:10,15'
            ],
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'The name must only contain letters and spaces.',
            'name.not_regex' => 'The name cannot contain numbers.',
            'id_number.numeric' => 'The ID number must contain only numbers.',
            'phone.numeric' => 'The phone number must contain only numbers.',
            'phone.digits_between' => 'The phone number must be between 10 and 15 digits.',
        ];
    }
}
