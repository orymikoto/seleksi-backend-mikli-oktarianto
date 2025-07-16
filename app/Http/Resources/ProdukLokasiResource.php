<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdukLokasiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'lokasi_id' => $this->id,
            'nama_lokasi' => $this->nama_lokasi,
            'kode_lokasi' => $this->kode_lokasi,
            'stok' => $this->pivot->stok,
            'last_updated' => $this->pivot->updated_at->toDateTimeString(),
            'produk' => $this->whenLoaded('produk', function () {
                return [
                    'id' => $this->produk->id,
                    'kode_produk' => $this->produk->kode_produk,
                    'nama_produk' => $this->produk->nama_produk
                ];
            })
        ];
    }
}