<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|integer|in:1,0',
            'facility_details' => 'nullable|array',
            'facility_details.*.name' => 'required|string|max:255',
            'facility_details.*.quantity' => 'required|integer|min:1',
            'facility_details.*.status' => 'required|integer|in:1,0',
        ];
    }
}

?>