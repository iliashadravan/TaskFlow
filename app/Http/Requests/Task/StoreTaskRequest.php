<?php

namespace App\Http\Requests\Task;


use App\Enums\PriorityEnum;
use App\Enums\StatusEnum;
use App\Http\Requests\Request;

class StoreTaskRequest extends Request
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
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',

            'assigned_to' => 'nullable|exists:users,id',

            'status'      => 'nullable|in:' . implode(',', StatusEnum::values()),
            'priority'    => 'nullable|in:' . implode(',', PriorityEnum::values()),
        ];
    }
}
