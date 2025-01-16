<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('id');        
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email' . $userId,
            'password' => 'nullable|string|min:8',
        ];
    }
}
