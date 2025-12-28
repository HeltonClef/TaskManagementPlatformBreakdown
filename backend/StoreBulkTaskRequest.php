<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBulkTaskRequest extends FormRequest
{
    public function rules()
    {
        return [
            'tasks' => 'required|array|min:1',
            'tasks.*.title' => 'required|string|max:255',
            'tasks.*.priority' => 'required|in:low,medium,high',
            'tasks.*.assignees' => 'array',
            'tasks.*.assignees.*' => 'exists:users,id',
            'tasks.*.subtasks' => 'array',
            'tasks.*.subtasks.*.title' => 'required|string|max:255',
        ];
    }
}
