<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
{
    public function authorize()
    {
        // Kembalikan true jika tidak menggunakan Auth
        return true;
    }

    public function rules()
    {
        return [
            'group_name' => 'required|string|max:255',
            'group_description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,user_id',
        ];
    }
}
