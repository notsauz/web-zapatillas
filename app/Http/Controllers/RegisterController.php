<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Mostrar el formulario de registro
     */
    public function showForm()
    {
        return view('auth.register');
    }

    /**
     * Procesar el registro del usuario
     */
    public function register(Request $request)
    {
        // Validar datos de entrada y proporcionar mensajes de error personalizados para cada campo 
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Crear el usuario en la base de datos y hashear la contraseña antes de guardarla
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Iniciar sesión automáticamente después del registro
        auth()->login($user);

        return redirect()->route('home')->with('success', 'Cuenta creada exitosamente. ¡Bienvenido!');
    }
}
