<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMutasiRequest;
use App\Http\Requests\TransferProdukRequest;
use App\Http\Resources\MutasiResource;
use App\Models\Mutasi;
use App\Models\ProdukLokasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MutasiController extends Controller
{
    /**
     * Display a listing of mutasi records
     */
    public function index(): JsonResponse
    {
        $mutasis = Mutasi::with(['user', 'produk', 'lokasiAsal', 'lokasiTujuan'])
            ->latest()
            ->paginate(20);

        return MutasiResource::collection($mutasis)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a new mutasi record
     */
    public function store(StoreMutasiRequest $request): JsonResponse
    {
        try {
            // Get authenticated user from the token
            $user = $request->user();
            
            // Create mutasi with user_id from the authenticated user
            $mutasiData = $request->validated();
            $mutasiData['user_id'] = $user->id;
            
            $mutasi = Mutasi::create($mutasiData);

            // Update stock if not a transfer (transfers handled separately)
            if ($mutasi->jenis_mutasi !== 'TRANSFER') {
                $produkLokasi = ProdukLokasi::find($mutasi->produk_lokasi_id);
                
                if ($mutasi->jenis_mutasi === 'MASUK') {
                    $produkLokasi->increment('stok', $mutasi->jumlah);
                } else {
                    $produkLokasi->decrement('stok', $mutasi->jumlah);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Mutasi recorded successfully',
                'data' => new MutasiResource($mutasi->load(['user', 'produk', 'lokasiAsal', 'lokasiTujuan']))
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to record mutasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified mutasi record
     */
    public function show(Mutasi $mutasi): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new MutasiResource($mutasi->load(['user', 'produk', 'lokasiAsal', 'lokasiTujuan']))
        ]);
    }

    /**
     * Transfer stock between locations
     */
    public function transfer(TransferProdukRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                // Validate stock availability
                $source = ProdukLokasi::where('produk_id', $request->produk_id)
                    ->where('lokasi_id', $request->lokasi_asal_id)
                    ->firstOrFail();

                if ($source->stok < $request->jumlah) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient stock in source location'
                    ], 422);
                }

                // Find or create destination record
                $destination = ProdukLokasi::firstOrCreate(
                    [
                        'produk_id' => $request->produk_id,
                        'lokasi_id' => $request->lokasi_tujuan_id
                    ],
                    ['stok' => 0]
                );

                // Update stocks
                $source->decrement('stok', $request->jumlah);
                $destination->increment('stok', $request->jumlah);

                // Record the transfer mutasi
                $mutasi = Mutasi::create([
                    'user_id' => auth()->id(),
                    'produk_lokasi_id' => $source->id,
                    'lokasi_asal_id' => $request->lokasi_asal_id,
                    'lokasi_tujuan_id' => $request->lokasi_tujuan_id,
                    'tanggal' => now(),
                    'jenis_mutasi' => 'TRANSFER',
                    'jumlah' => $request->jumlah,
                    'keterangan' => $request->keterangan
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Stock transferred successfully',
                    'data' => new MutasiResource($mutasi->load(['user', 'produk', 'lokasiAsal', 'lokasiTujuan']))
                ], 201);
            });

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to transfer stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a mutasi record
     */
    public function destroy(Mutasi $mutasi): JsonResponse
    {
        try {
            $mutasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Mutasi record deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete mutasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get mutasi history for specific user
     * 
     * @param int $userId
     * @return JsonResponse
     */
    public function getByUser($userId): JsonResponse
    {
        try {

            $mutasis = Mutasi::with(['produk', 'lokasiAsal', 'lokasiTujuan'])
                ->where('user_id', $userId)
                ->orderBy('tanggal', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => MutasiResource::collection($mutasis),
                'meta' => [
                    'current_page' => $mutasis->currentPage(),
                    'per_page' => $mutasis->perPage(),
                    'total' => $mutasis->total(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch user mutasi records',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get mutasi history for specific product
     * 
     * @param int $produkId
     * @return JsonResponse
     */
    public function getByProduk($produkId): JsonResponse
    {
        try {
            $mutasis = Mutasi::with(['user', 'lokasiAsal', 'lokasiTujuan'])
                ->whereHas('produkLokasi', function($query) use ($produkId) {
                    $query->where('produk_id', $produkId);
                })
                ->orderBy('tanggal', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => MutasiResource::collection($mutasis),
                'meta' => [
                    'current_page' => $mutasis->currentPage(),
                    'per_page' => $mutasis->perPage(),
                    'total' => $mutasis->total(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch product mutasi records',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}