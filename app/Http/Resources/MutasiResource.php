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
            'produk' => $this->whenLoaded('produkLokasi.produk', function () {
                return [
                    'id' => $this->produkLokasi->produk->id,
                    'kode_produk' => $this->produkLokasi->produk->kode_produk,
                    'nama_produk' => $this->produkLokasi->produk->nama_produk
                ];
            }),
            'lokasi_asal' => $this->when($this->lokasi_asal_id, function () {
                return [
                    'id' => $this->lokasi_asal_id,
                    'nama_lokasi' => $this->lokasiAsal->nama_lokasi
                ];
            }),
            'lokasi_tujuan' => $this->when($this->lokasi_tujuan_id, function () {
                return [
                    'id' => $this->lokasi_tujuan_id,
                    'nama_lokasi' => $this->lokasiTujuan->nama_lokasi
                ];
            }),
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name
                ];
            }),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}