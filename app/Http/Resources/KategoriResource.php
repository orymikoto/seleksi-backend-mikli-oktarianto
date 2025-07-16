<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KategoriResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_kategori' => $this->nama_kategori,
            'satuan' => $this->whenLoaded('satuan', function () {
                return $this->satuan->satuan;
            }),
            'jumlah_produk' => $this->whenCounted('produks'),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}