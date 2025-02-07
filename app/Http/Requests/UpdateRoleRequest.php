<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Bisa tambahkan logika otorisasi di sini jika perlu
        return true;
    }

    public function rules()
    {
        $roleId = $this->route('id');
        return [
            'role_name' => [
                'required',
                'string',
                Rule::unique('roles')->ignore($roleId, 'role_id'),
                
            ],
            'role_description' => 'nullable|string',
        ];
    }
}
