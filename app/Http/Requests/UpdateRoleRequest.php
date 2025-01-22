<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
        $roleId = $this->route('role');
        return [
            'role_name' => 'required|string|max:255|unique:roles,role_name,' . $roleId . ',role_id',
            // 'role_name',
            //     Rule::unique('rules')->ignore($roleId, 'role_id'),
            'role_description' => 'nullable|string',
        ];
    }
}
