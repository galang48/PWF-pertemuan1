<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',

            'quantity.required' => 'Jumlah (kuantitas) produk wajib diisi.',
            'quantity.integer' => 'Jumlah produk harus berupa angka bulat (tidak boleh desimal).',

            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga produk harus berupa angka yang valid.',

            'user_id.required' => 'Pemilik produk wajib dipilih.',
            'user_id.exists' => 'User yang dipilih tidak valid.',
        ];
    }
}
