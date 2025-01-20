<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('user'); 
        // dd($userId);
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId, 'user_id'),
                
            ],
            'current_password' => 'required_with:password|string', 
            'password' => 'nullable|string|min:8|confirmed', 
        ];
    }
    public function messages()
    {
        return [
            'current_password.required_with' => 'Current password is required when changing the password.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}