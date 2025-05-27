<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'is_completed' => ['required', 'boolean'],
            'due_date' => ['nullable', 'date'],
            'media' => ['nullable', 'file', 'max:10240'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:task_categories,id'],
        ];
    }
}
