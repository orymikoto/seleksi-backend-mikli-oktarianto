<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdukLokasiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'produk_id' => $this->id,
            'kode_produk' => $this->kode_produk,
            'nama_produk' => $this->nama_produk,
            'harga' => $this->harga,
            'stok' => $this->pivot->stok,
            'last_updated' => $this->pivot->updated_at->toDateTimeString(),
            'kategori' => $this->whenLoaded('kategori', function () {
                return [
                    'id' => $this->kategori->id,
                    'nama' => $this->kategori->nama_kategori
                ];
            }),
        ];
    }
}