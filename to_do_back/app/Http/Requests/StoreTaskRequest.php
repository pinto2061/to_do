<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //return false;
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
            'name' => 'required|string|max:255',
            'description' => 'required|string', // No es necesario max:255 si tu campo es TEXT
            'finish_date' => 'required|date', // 'date' es una regla mejor que 'string'
            'user_id' => 'required|exists:users,id', // 'exists' asegura que el user_id existe en la tabla users
            'category_id' => 'required|exists:categories,id', // 'exists' asegura que el category_id existe
        ];
    }
}
