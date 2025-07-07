<?php

namespace App\Http\Requests\Site\Logo;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreLogoRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048|dimensions:min_width=100,min_height=100',
            'name' => 'required|min:3|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'O campo logo é obrigatório.',
            'image.image' => 'O arquivo deve ser uma imagem (JPEG, PNG, BMP, GIF, SVG ou WEBP).',
            'image.mimes' => 'O tipo de imagem deve ser JPEG, JPG, PNG ou GIF.',
            'image.max' => 'O tamanho máximo do arquivo deve ser 2MB.',
            'image.dimensions' => 'A imagem deve ter no mínimo 1000x1000 pixels.',
            'name.required' => 'O campo nome é obrigatório.',
            'name.min' => 'O nome deve ter no mínimo :min caracteres.',
            'name.max' => 'O nome deve ter no máximo :max caracteres.',
        ];
    }
}
