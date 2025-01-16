<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'role_name' => 'required|string',
            'role_description' => 'nullable|string',
        ];
    }
}
