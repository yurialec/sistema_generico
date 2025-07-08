<?php

namespace App\Http\Requests\Site\MainText;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaintextRequest extends FormRequest
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
            'title' => 'sometimes|min:3|max:255',
            'text' => 'sometimes|min:3|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.min' => 'O título deve ter no mínimo 3 caracteres.',
            'title.max' => 'O título deve ter no máximo 255 caracteres.',
            'text.min' => 'O texto deve ter no mínimo 3 caracteres.',
            'text.max' => 'O texto deve ter no máximo 255 caracteres.',
        ];
    }
}
