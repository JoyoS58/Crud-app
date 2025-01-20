<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize()
    {
        // Bisa tambahkan logika otorisasi di sini jika perlu
        return true;
    }

    public function rules()
    {
        return [
            'role_name' => 'required|string|unique:roles,role_name',
            'role_description' => 'nullable|string',
        ];
    }
}
