<?php

namespace App\Http\Requests\Admin\Feedback;

use App\Enums\FeedbackStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normaliza inputs antes da validação:
     * - remove textos vazios em evidences_text[]
     */
    protected function prepareForValidation(): void
    {
        $texts = $this->input('evidences_text', []);
        if (is_array($texts)) {
            $texts = array_values(array_filter(array_map(
                fn($t) => is_string($t) ? trim($t) : $t,
                $texts
            ), fn($t) => !empty($t)));
        }

        $this->merge([
            'evidences_text' => $texts,
        ]);
    }

    /**
     * Regras de validação para atualização.
     *
     * - Campos principais (`title`, `description`) agora são opcionais.
     * - Evidências podem ser enviadas incrementalmente (novas ou complementares).
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:150'],
            'description' => ['sometimes', 'string', 'min:10'],
            'status' => ['nullable', new Enum(FeedbackStatus::class)],

            // Anexos (múltiplos): imagens/PDFs
            'evidences_files' => ['nullable', 'array', 'max:10'],
            'evidences_files.*' => ['file', 'mimes:jpg,jpeg,png,webp,gif,pdf', 'max:20480'], // 20 MB

            // Evidências de texto (múltiplas)
            'evidences_text' => ['nullable', 'array', 'max:20'],
            'evidences_text.*' => ['string', 'min:3', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'O título deve ser um texto.',
            'title.max' => 'O título deve ter no máximo :max caracteres.',

            'description.string' => 'A descrição deve ser um texto.',
            'description.min' => 'A descrição deve ter pelo menos :min caracteres.',

            'status.enum' => 'Status inválido. Use "open" ou "done".',

            'evidences_files.array' => 'Os anexos devem ser enviados como uma lista.',
            'evidences_files.max' => 'Você pode enviar no máximo :max arquivos por feedback.',
            'evidences_files.*.file' => 'Cada anexo deve ser um arquivo válido.',
            'evidences_files.*.mimes' => 'Arquivos devem ser do tipo: jpg, jpeg, png, webp, gif ou pdf.',
            'evidences_files.*.max' => 'Cada arquivo não pode ultrapassar :max kilobytes.',

            'evidences_text.array' => 'As evidências de texto devem ser enviadas como uma lista.',
            'evidences_text.max' => 'Você pode enviar no máximo :max evidências de texto.',
            'evidences_text.*.string' => 'Cada evidência de texto deve ser um texto.',
            'evidences_text.*.min' => 'Cada evidência de texto deve ter ao menos :min caracteres.',
            'evidences_text.*.max' => 'Cada evidência de texto deve ter no máximo :max caracteres.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'título',
            'description' => 'descrição',
            'evidences_files' => 'anexos',
            'evidences_files.*' => 'anexo',
            'evidences_text' => 'evidências de texto',
            'evidences_text.*' => 'evidência de texto',
        ];
    }
}
