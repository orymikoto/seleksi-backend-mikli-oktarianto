<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $kode_lokasi
 * @property string|null $penanggung_jawab_id
 * @property string $nama_lokasi
 * @property string|null $alamat_lengkap
 * @property string|null $x_coordinate
 * @property string|null $y_coordinate
 */
class UpdateLokasiRequest extends FormRequest
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
            'penanggung_jawab_id' => 'nullable|exists:penanggung_jawabs,id',
            'nama_lokasi' => 'required|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'x_coordinate' => 'nullable|string|max:50',
            'y_coordinate' => 'nullable|string|max:50',
        ];
    }
}
