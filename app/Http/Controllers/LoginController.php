<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'El nombre de usuario o email es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Obtener el valor ingresado
        $loginValue = $validated['email'];
        $password = $validated['password'];

        // Intentar autenticar con username, email o nombre
        $user = User::where('username', $loginValue)
                    ->orWhere('email', $loginValue)
                    ->first();

        // Verificar contraseña y autenticar al usuario
        if ($user && Hash::check($password, $user->password)) {
            auth()->login($user, $request->filled('remember'));
            $request->session()->regenerate();
            return redirect()->route('catalogo')->with('success', 'Sesión iniciada correctamente.');
        }

        // Si falla la autenticación regresar al formulario con un mensaje de error
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Nombre de usuario, email o contraseña incorrectos.']);
    }
}
