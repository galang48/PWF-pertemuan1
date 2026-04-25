<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',

            'quantity.integer' => 'Jumlah produk harus berupa angka bulat.',

            'price.numeric' => 'Harga produk harus berupa angka yang valid.',

            'category_id.required' => 'Kategori produk wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
        ];
    }
}
