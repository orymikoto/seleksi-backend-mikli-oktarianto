<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @mixin \Illuminate\Http\Request
 * @property string $kode_produk
 * @property int $kategori_id
 * @property string $nama_produk
 * @property float $harga
 * @property string $deskripsi
 * @property-read array $lokasi_ids
 * @property-read \Illuminate\Http\UploadedFile|null $gambar
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
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'satuan' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // 'stok' is required if 'lokasi_ids' is present, and must be an array
            'stok' => 'nullable|array',
            'stok.*' => 'required|integer|min:0', 

            // Make Location Required if stok present
            'lokasi_ids' => 'required_with:stok|nullable|array',
            'lokasi_ids.*' => 'required|exists:lokasis,id', // Each ID must exist
            
        ];
    }
}
