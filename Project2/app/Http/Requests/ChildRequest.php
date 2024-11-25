<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChildRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'birthDate' => 'required|date',
            'gender' => 'required|in:1,2',
            'user_id' => 'required|exists:users,id',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'note' => 'nullable|string',
            'status' => 'required|boolean',
        ];
    }
}