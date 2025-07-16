<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferProdukRequest extends FormRequest
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
            'produk_id' => 'required|exists:produks,id',
            'lokasi_asal_id' => 'required|exists:lokasis,id',
            'lokasi_tujuan_id' => 'required|exists:lokasis,id|different:lokasi_asal_id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'lokasi_tujuan_id.different' => 'Source and destination locations must be different'
        ];
    }
}
