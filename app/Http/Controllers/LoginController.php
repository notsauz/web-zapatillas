<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function showForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el login del usuario
     */
    public function login(Request $request)
    {
        // Validar datos de entrada
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Intentar autenticar al usuario con las credenciales proporcionadas y la opción "remember me" si está marcada
        if (auth()->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Sesión iniciada correctamente.');
        }

        // Si falla la autenticación regresar al formulario con un mensaje de error y conservar el email ingresado para facilitar la corrección
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email o contraseña incorrectos.']);
    }
}
