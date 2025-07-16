<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::apiResource('users', UserController::class)->except(['store']);
    
    Route::prefix('produk')->group(function () {
        Route::get('/search', [ProdukController::class, 'search']);
        Route::get('/low-stock', [ProdukController::class, 'lowStock']);

        // Basic CRUD
        Route::get('/', [ProdukController::class, 'index']);
        Route::post('/', [ProdukController::class, 'store']);
        Route::get('/{produk}', [ProdukController::class, 'show']);
        Route::put('/{produk}', [ProdukController::class, 'update']);
        Route::delete('/{produk}', [ProdukController::class, 'destroy']);

    });
    Route::get('produk/{product}/mutations', [ProdukController::class, 'productMutations']);
    
    Route::prefix('lokasi')->group(function () {
        // Additional features
        Route::get('/search', [LokasiController::class, 'search']);
        
        // Basic CRUD
        Route::get('/', [LokasiController::class, 'index']);
        Route::post('/', [LokasiController::class, 'store']);
        Route::get('/{lokasi}', [LokasiController::class, 'show']);
        Route::put('/{lokasi}', [LokasiController::class, 'update']);
        Route::delete('/{lokasi}', [LokasiController::class, 'destroy']);
        
    });
    
    // Mutation routes
    Route::prefix('mutasi')->group(function () {
        // Special operations
        Route::post('/transfer', [MutasiController::class, 'transfer']);
        Route::get('user/{userId}', [MutasiController::class, 'getByUser']);
        Route::get('produk/{produkId}', [MutasiController::class, 'getByProduk']);
        
        // Basic CRUD
        Route::get('/', [MutasiController::class, 'index']);
        Route::post('/', [MutasiController::class, 'store']);
        Route::get('/{mutasi}', [MutasiController::class, 'show']);
        Route::delete('/{mutasi}', [MutasiController::class, 'destroy']);
        
    });
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});