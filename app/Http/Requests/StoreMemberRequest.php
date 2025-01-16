<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  // Set to true to allow this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,user_id',
            'group_id' => 'required|exists:groups,group_id',
            'join_date' => 'nullable|date',
            'status' => 'nullable|string|in:active,inactive',
            'role_in_group' => 'nullable|string|max:255',
        ];
    }
}
