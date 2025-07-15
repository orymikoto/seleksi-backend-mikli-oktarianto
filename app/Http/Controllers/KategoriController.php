<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use Illuminate\Http\JsonResponse;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $kategoris = Kategori::all();
    
            return response()->json([
                'success' => true,
                'message' => 'Semua kategori berhasil diterima',
                'data' => $kategoris
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada sistem',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriRequest $request): JsonResponse
    {
        try {
            // The validation is already handled by StoreKategoriRequest
            // If we get here, validation passed
            
            $kategori = Kategori::create([
                'nama' => $request->nama,
                'satuan_id' => $request->satuan_id // assuming this is in your request
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori created successfully',
                'data' => $kategori
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create kategori',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriRequest $request, Kategori $kategori)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        //
    }
}
