<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @mixin \Illuminate\Http\Request
 * @property string $kode_lokasi
 * @property string $nama_lokasi
 * @property int $penanggung_jawab_id
 * @property string $alamat_lengkap
 * @property string $x_coordinate
 * @property string $y_coordinate
 */
class StoreLokasiRequest extends FormRequest
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
            'kode_lokasi' => 'required|string|max:50|unique:lokasis,kode_lokasi',
            'nama_lokasi' => 'required|string|max:255',
            'penanggung_jawab_id' => 'required|exists:users,id',
            'alamat_lengkap' => 'required|string',
            'x_coordinate' => 'required|regex:/^-?\d{1,3}(\.\d+)?$/',
            'y_coordinate' => 'required|regex:/^-?\d{1,3}(\.\d+)?$/',
        ];
    }
}