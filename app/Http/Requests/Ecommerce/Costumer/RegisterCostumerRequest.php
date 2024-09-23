<?php

namespace App\Http\Requests\Ecommerce\Costumer;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCostumerRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:costumers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required'],
        ];
    }
}
