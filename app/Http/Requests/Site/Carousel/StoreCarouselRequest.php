<?php

namespace App\Http\Requests\Site\Carousel;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarouselRequest extends FormRequest
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
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'A imagem é obrigatória.',
            'image.file' => 'A imagem deve ser um arquivo válido.',
            'image.image' => 'A imagem deve ser um arquivo de imagem válido.',
            'image.mimes' => 'A imagem deve ser um arquivo do tipo: :values.',
            'image.max' => 'A imagem não pode ser maior que :max kilobytes.',
        ];
    }
}
