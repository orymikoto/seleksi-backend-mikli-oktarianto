<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Http\Requests\StoreLokasiRequest;
use App\Http\Requests\UpdateLokasiRequest;
use App\Http\Resources\LokasiResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    /**
     * Display a listing of locations with pagination
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('perPage') ?? 10;
        
        $lokasis = Lokasi::with(['penanggungJawab', 'produks.kategori'])
            ->orderBy('nama_lokasi')
            ->paginate($perPage);

        return LokasiResource::collection($lokasis)
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Display the specified location
     */
    public function show(Lokasi $lokasi): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new LokasiResource($lokasi->load(['penanggungJawab', 'produks.kategori']))
        ]);
    }

    /**
     * Store a newly created location
     */
    public function store(StoreLokasiRequest $request): JsonResponse
    {
        try {
            $lokasi = Lokasi::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Location created successfully',
                'data' => new LokasiResource($lokasi->load('penanggungJawab'))
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create location',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified location
     */
    public function update(UpdateLokasiRequest $request, Lokasi $lokasi): JsonResponse
    {
        try {
            $lokasi->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Location updated successfully',
                'data' => new LokasiResource($lokasi->fresh()->load('penanggungJawab'))
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update location',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search locations by name or code
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('query');

        $lokasis = Lokasi::where('nama_lokasi', 'ilike', '%'.$query.'%')
            ->orWhere('kode_lokasi', 'ilike', '%'.$query.'%')
            ->with('penanggungJawab')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => LokasiResource::collection($lokasis)
        ]);
    }

    /**
     * Remove the specified location
     */
    public function destroy(Lokasi $lokasi): JsonResponse
    {
        try {
            // Check if location has products
            if ($lokasi->produks()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete location with associated products'
                ], 422);
            }

            $lokasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Location deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete location',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
