<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\JadwalController;
use App\Http\Controllers\API\KhotbahController;
use App\Models\Jadwal;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// menampilkan jadwal dan khotbah
Route::get('jadwal', [JadwalController::class, 'index']);
Route::get('khotbah', [KhotbahController::class, 'index']);

//create jadwal dan khotbah
Route::post('jadwal', [JadwalController::class, 'store']);
Route::post('khotbah', [KhotbahController::class, 'store']);


//delete jadwal dan khotbah

//update jadwal dan khotbah
Route::get('jadwal/{id}', [JadwalController::class, 'show']);
Route::put('jadwal/{id}', [JadwalController::class, 'update']); // Menggunakan PUT saja


Route::get('khotbah/{id}', [KhotbahController::class, 'show']);
Route::put('khotbah/{id}', [KhotbahController::class, 'update']);
