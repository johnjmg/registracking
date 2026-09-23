<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeudorController;
use App\Http\Controllers\DeudaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de deudores, dentro del grupo auth, con parámetro renombrado
    Route::resource('deudores', DeudorController::class)
        ->parameters(['deudores' => 'deudor']);

    // Rutas de deudas, dentro del grupo auth, con parámetro renombrado
    Route::resource('deudas', DeudaController::class)
        ->parameters(['deudas' => 'deuda']);

    // Rutas de pagos, dentro del grupo auth, con parámetro renombrado
    Route::post('deudas/{deuda}/pagos', [PagoController::class, 'store'])->name('pagos.store');
    Route::delete('pagos/{pago}', [PagoController::class, 'destroy'])->name('pagos.destroy');
});

require __DIR__.'/auth.php';
