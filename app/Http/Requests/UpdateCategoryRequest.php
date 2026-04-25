<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-category') ?? false;
    }

    public function rules(): array
    {
        $category = $this->route('category') ?? $this->route('id');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($category?->id ?? $category),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama category wajib diisi.',
            'name.max' => 'Nama category tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama category sudah digunakan.',
        ];
    }
}
