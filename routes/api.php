<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::apiResource('users', UserController::class)->except(['store']);
    
    // Product routes
    Route::apiResource('produk', ProdukController::class);
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