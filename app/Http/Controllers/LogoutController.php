<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Cerrar la sesión del usuario
     */
    public function logout(Request $request)
    {
        // Cerrar sesión y limpiar la sesión
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir al inicio con mensaje de éxito
        return redirect()->route('home')->with('success', 'Sesión cerrada correctamente.');
    }
}
