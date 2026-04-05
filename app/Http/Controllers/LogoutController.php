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
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('zapatillas.index')->with('success', 'Sesión cerrada correctamente.');
    }
}
