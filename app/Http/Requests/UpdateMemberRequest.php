<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        return [
            'userId' => 'required|exists:users,user_id',
            'groupId' => 'required|exists:groups,group_id',
            'join_date' => 'nullable|date',
            'status' => 'string|in:active,inactive',
            'role_in_group' => 'nullable|string|max:255',
        ];
    }
}
