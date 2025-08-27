<?php

namespace App\Http\Requests\Site\Carousel;

use App\Models\Site\SiteCarousel;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCarouselRequest extends FormRequest
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
            'image'     => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('image', 'required', function ($input) {
            $model = SiteCarousel::find($this->route('id'));
            return !$model || !$model->image;
        });
    }

    public function messages(): array
    {
        return [
            'image.file'              => 'A imagem deve ser um arquivo válido.',
            'image.image'             => 'A imagem deve ser um arquivo de imagem válido.',
            'image.mimes'             => 'A imagem deve ser um arquivo do tipo: :values.',
            'image.max'               => 'A imagem não pode ser maior que :max kilobytes.',
            'image.required'          => 'A imagem é obrigatória.',
        ];
    }
}
