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
            'role_id' => 'nullable|integer|exists:roles,role_id',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId, 'user_id'),
                
            ],
            'current_password' => 'required_if:password,!=,null|string',
            'password' => 'nullable|string|min:8|confirmed', 
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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