<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Muestra el formulario de inicio de sesión
    public function showForm()
    {
        return view("auth.login");
    }

    // Procesa el inicio de sesión
    public function login(Request $peticion)
    {
        $datos = $peticion->validate([
            "email" => "required|string",
            "password" => "required|string",
        ]);

        // Buscar usuario por email o username
        $usuario = User::where("username", $datos["email"])
            ->orWhere("email", $datos["email"])
            ->first();

        // Verificar credenciales
        if ($usuario && Hash::check($datos["password"], $usuario->password)) {
            auth()->login($usuario, $peticion->filled("remember"));
            $peticion->session()->regenerate();
            return redirect()->route("catalogo")->with("success", "Sesión iniciada correctamente.");
        }

        return back()->withErrors(["email" => "Credenciales incorrectas."])->withInput($peticion->only("email"));
    }
}