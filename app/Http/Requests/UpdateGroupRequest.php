<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $groupId = $this->route('group');
        return [
            // 'group_name' => 'required|string|max:255|unique:groups,group_name' . $groupId . ',group_id',
            'group_name',
                Rule::unique('groups')->ignore($groupId, 'group_id'),
            'group_description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,user_id',

        ];
    }
}
