<?php

namespace App\Http\Requests\Admin\Feedback;

use App\Enums\FeedbackStatus;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreFeedbackRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'min:10'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'status' => ['nullable', new Enum(FeedbackStatus::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.string' => 'O título deve ser um texto.',
            'title.max' => 'O título deve ter no máximo :max caracteres.',

            'description.required' => 'A descrição é obrigatória.',
            'description.string' => 'A descrição deve ser um texto.',
            'description.min' => 'A descrição deve ter pelo menos :min caracteres.',

            'image.image' => 'O arquivo enviado deve ser uma imagem válida.',
            'image.mimes' => 'A imagem deve ser do tipo: :values.',
            'image.max' => 'A imagem não pode ultrapassar :max kilobytes.',

            'image_path.string' => 'O caminho da imagem deve ser um texto.',
            'image_path.max' => 'O caminho/URL da imagem deve ter no máximo :max caracteres.',
            'image_path.url' => 'Informe uma URL válida para a imagem.',

            'status.enum' => 'Status inválido. Use "open" ou "done".',
        ];
    }
}
