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
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
            'user_id' => 'sometimes|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',

            'quantity.integer' => 'Jumlah produk harus berupa angka bulat.',

            'price.numeric' => 'Harga produk harus berupa angka yang valid.',

            'user_id.exists' => 'User yang dipilih tidak valid.',
        ];
    }
}
