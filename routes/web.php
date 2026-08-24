<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReceptionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (Login)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas — Recepción (host y admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:host,admin'])->group(function () {
    Route::get('/reception', [ReceptionController::class, 'index']);
    Route::post('/reception', [ReceptionController::class, 'store']);
    Route::patch('/reception/{wash}/status', [ReceptionController::class, 'updateStatus'])->name('reception.updateStatus');
});

/*
|--------------------------------------------------------------------------
| Rutas Protegidas — Administración (solo admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::delete('/admin/wash/{wash}', [AdminController::class, 'destroyWash'])->name('admin.destroyWash');
});
