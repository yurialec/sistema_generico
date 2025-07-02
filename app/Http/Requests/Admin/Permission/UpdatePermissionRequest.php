<?php

namespace App\Http\Requests\Admin\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
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
        $permissionId = $this->route('permission');
        $permissionId = is_object($permissionId) ? $permissionId->id : $permissionId;

        return [
            'name' => [
                'required',
                'min:3',
                'max:255',
                Rule::unique('permissions', 'name')->ignore($permissionId),
            ],
            'label' => [
                'required',
                'min:3',
                'max:255',
                Rule::unique('permissions', 'label')->ignore($permissionId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'name.unique' => 'Este nome de permissão já está em uso.',

            'label.required' => 'O campo rótulo é obrigatório.',
            'label.min' => 'O campo rótulo deve ter no mínimo 3 caracteres.',
            'label.max' => 'O campo rótulo deve ter no máximo 255 caracteres.',
            'label.unique' => 'Este rótulo de permissão já está em uso.',
        ];
    }
}
