<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $kode_produk
 * @property int $kategori_id
 * @property string $nama_produk
 * @property float $harga
 * @property string $deskripsi
 */
class StoreProdukRequest extends FormRequest
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
            'kode_produk' => 'required|string|max:50|unique:produks,kode_produk',
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
        ];
    }
}
