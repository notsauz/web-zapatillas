<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZapatillaController;

// Redireccionar la raíz a la lista de zapatillas
Route::get('/', function () {
    return redirect()->route('zapatillas.index');
});

// Rutas para CRUD de Zapatillas
Route::resource('zapatillas', ZapatillaController::class);
