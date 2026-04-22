<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    // Cerrar sesión del usuario y limpiar la sesión con mensajes personalizados
    public function logout(Request $peticion)
    {
        // Cerrar sesión y limpiar la sesión
        auth()->logout();
        $peticion->session()->invalidate();
        $peticion->session()->regenerateToken();

        // Redirigir al inicio con mensaje de éxito
        return redirect()->route("home")->with("success", "Sesión cerrada correctamente.");
    }
}