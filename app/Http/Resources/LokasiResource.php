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
            'produk_tersedia' => $this->whenLoaded('produks', function () {
                return $this->produks->map(function ($produk) {
                    return [
                        'produk_id' => $produk->id,
                        'kode_produk' => $produk->kode_produk,
                        'nama_produk' => $produk->nama_produk,
                        'harga' => $produk->harga,
                        'stok' => $produk->pivot->stok,
                        'kategori' => $produk->kategori ? [
                            'id' => $produk->kategori->id,
                            'nama' => $produk->kategori->nama_kategori
                        ] : null
                    ];
                });
            }),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}