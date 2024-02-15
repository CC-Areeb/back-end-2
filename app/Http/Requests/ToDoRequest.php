<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToDoRequest extends FormRequest
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
            "task_name"=> "nullable|string",
            "task_description"=> "nullable|string",
            "task_creator"=> "nullable",
            "user_id" => "nullable",
            "start_date"=> "string|nullable",
            "end_date"=> "string|nullable",
            "start"=> "boolean",
            "finish"=> "boolean",
        ];
    }

}
