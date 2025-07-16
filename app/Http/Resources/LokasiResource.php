<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LokasiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode_lokasi' => $this->kode_lokasi,
            'nama_lokasi' => $this->nama_lokasi,
            'alamat_lengkap' => $this->alamat_lengkap,
            'koordinat' => [
                'x' => $this->x_coordinate,
                'y' => $this->y_coordinate
            ],
            'penanggung_jawab' => $this->whenLoaded('penanggungJawab', function () {
                return [
                    'id' => $this->penanggungJawab->id,
                    'nama' => $this->penanggungJawab->nama
                ];
            }),
            'produk_tersedia' => ProdukLokasiResource::collection($this->whenLoaded('produks')),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}