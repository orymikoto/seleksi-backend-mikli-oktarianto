<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $user_id
 * @property int $produk_lokasi_id
 * @property int|null $lokasi_asal_id
 * @property int|null $lokasi_tujuan_id
 * @property string $tanggal
 * @property string $jenis_mutasi
 * @property int $jumlah
 * @property string|null $keterangan
 */
class StoreMutasiRequest extends FormRequest
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
            'user_id' => 'sometimes|exists:users,id',
            'produk_lokasi_id' => 'sometimes|exists:produk_lokasi,id',
            'lokasi_asal_id' => 'nullable|required_if:jenis_mutasi,TRANSFER|exists:lokasis,id',
            'lokasi_tujuan_id' => 'nullable|required_if:jenis_mutasi,TRANSFER|exists:lokasis,id',
            'tanggal' => 'sometimes|date',
            'jenis_mutasi' => 'sometimes|in:MASUK,KELUAR,TRANSFER',
            'jumlah' => 'sometimes|integer|min:1',
            'keterangan' => 'nullable|string',
        ];
    }
}
