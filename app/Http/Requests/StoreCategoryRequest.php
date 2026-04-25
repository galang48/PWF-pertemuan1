<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-category') ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name',
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
