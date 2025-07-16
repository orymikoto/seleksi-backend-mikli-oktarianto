<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Http\Resources\ProdukResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page') ?? 10;

        $produks = Produk::with(['kategori', 'lokasis'])
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);

        // The API Resource handles the JSON structure automatically
        return ProdukResource::collection($produks)
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(StoreProdukRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            
            // Handle image upload if present
            if ($request->hasFile('gambar')) {
                $data['gambar'] = $request->file('gambar')->store('produk-images', 'public');
            }

            $produk = Produk::create($data);

            // Sync locations with stocks
            if (!empty($request['lokasi_ids'])) {
                $syncData = [];
                // Loop through the validated location IDs.
                foreach ($request['lokasi_ids'] as $index => $lokasiId) {
                    // Match each location ID with its corresponding stock value from the validated data.
                    // This ensures the arrays are correctly paired.
                    $syncData[$lokasiId] = ['stok' => $request['stok'][$index]];
                }
                // Sync the data to the pivot table.
                $produk->lokasis()->sync($syncData);
            }


            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $produk->load('kategori', 'lokasis')
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
        $produk->load(['kategori', 'lokasis']);

        return (new ProdukResource($produk))->response();
    }

   /**
     * Update the specified product
     */
    public function update(UpdateProdukRequest $request, Produk $produk): JsonResponse
    {
        try {
            $data = $request->validated();
            
            // Handle image update
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($produk->gambar) {
                    Storage::disk('public')->delete($produk->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('produk-images', 'public');
            }

            $produk->update($data);

            // Sync locations if provided
            if ($request->has('lokasi_ids')) {
                $produk->lokasis()->sync($request->lokasi_ids);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => $produk->fresh()->load('kategori', 'lokasis')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified product
     */
    public function destroy(Produk $produk): JsonResponse
    {
        try {
            // Delete associated image if exists
            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $produk->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search products by name or code
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('query');
        
        $produks = Produk::where('nama_produk', 'like', "%$query%")
            ->orWhere('kode_produk', 'like', "%$query%")
            ->with('kategori')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Search results',
            'data' => $produks
        ]);
    }

    /**
     * Get low stock products
     */
    public function lowStock(Request $request): JsonResponse
    {
        $threshold = $request->input('threshold', 10);
        
        $produks = Produk::whereHas('lokasis', function($query) use ($threshold) {
                $query->where('stok', '<=', $threshold);
            })
            ->with(['lokasis' => function($query) use ($threshold) {
                $query->wherePivot('stok', '<=', $threshold);
            }])
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Low stock products',
            'data' => $produks,
            'threshold' => $threshold
        ]);
    }
}
