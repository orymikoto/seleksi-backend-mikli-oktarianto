<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdukResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode_produk' => $this->kode_produk,
            'nama_produk' => $this->nama_produk,
            'harga' => $this->harga,
            'gambar' => $this->gambar ? asset('storage/' . $this->gambar) : null,
            'satuan' => $this->satuan,
            'deskripsi' => $this->deskripsi,
            'kategori' => $this->whenLoaded('kategori', new KategoriResource($this->kategori)),
            'lokasi_dan_stok' => LokasiResource::collection($this->whenLoaded('lokasis')),
            'mutasi_terakhir' => $this->whenLoaded('mutasis', function () {
                return new MutasiResource($this->mutasis->last());
            }),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}