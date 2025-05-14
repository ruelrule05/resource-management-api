<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['nullable'],
            'status' => ['required', Rule::in(['pending', 'to do', 'in progress', 'completed', 'on hold'])],
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'due_date' => ['nullable', 'date'],
        ];
    }
}
