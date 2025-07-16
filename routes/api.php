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
        
        // Additional features
    });
    Route::get('produk/{product}/mutations', [ProdukController::class, 'productMutations']);
    
    // Location routes
    Route::apiResource('lokasi', LokasiController::class);
    
    // Mutation routes
    Route::apiResource('mutasi', MutasiController::class);
    Route::post('mutasi/transfer', [MutasiController::class, 'transferProdukLokasi']);
    Route::get('users/{user}/mutasi', [UserController::class, 'userMutations']);
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});