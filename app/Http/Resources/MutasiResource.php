<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MutasiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tanggal' => $this->tanggal->toDateTimeString(),
            'jenis_mutasi' => $this->jenis_mutasi,
            'jumlah' => $this->jumlah,
            'keterangan' => $this->keterangan,
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name
                ];
            }),
            'produk' => $this->whenLoaded('produk', function () {
                return [
                    'id' => $this->produk->id,
                    'kode_produk' => $this->produk->kode_produk,
                    'nama_produk' => $this->produk->nama_produk,
                    'harga' => $this->produk->harga
                ];
            }),
            'lokasi_asal' => $this->whenLoaded('lokasiAsal', function () {
                return [
                    'id' => $this->lokasi_asal_id,
                    'kode_lokasi' => $this->lokasiAsal->kode_lokasi,
                    'nama_lokasi' => $this->lokasiAsal->nama_lokasi
                ];
            }),
            'lokasi_tujuan' => $this->whenLoaded('lokasiTujuan', function () {
                return $this->lokasi_tujuan_id ? [
                    'id' => $this->lokasi_tujuan_id,
                    'kode_lokasi' => $this->lokasiTujuan->kode_lokasi,
                    'nama_lokasi' => $this->lokasiTujuan->nama_lokasi
                ] : null;
            }),
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}