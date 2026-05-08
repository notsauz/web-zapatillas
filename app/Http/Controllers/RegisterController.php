<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Muestra el formulario de registro de usuario
    public function showForm()
    {
        return view("auth.register");
    }

    // Procesar el registro del usuario con validación y mensajes personalizados para cada campo, además de hashear la contraseña antes de guardarla en la base de datos
    public function register(Request $peticion)
    {
        // Validar datos de entrada y proporcionar mensajes de error personalizados para cada campo 
        $datos = $peticion->validate([
            "name" => "required|string|max:255",
            "username" => "required|string|max:255|unique:users,username|regex:/^[a-zA-Z0-9_-]+$/",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:6|confirmed",
        ], [
            "name.required" => "El nombre es obligatorio.",
            "username.required" => "El nombre de usuario es obligatorio.",
            "username.unique" => "Este nombre de usuario ya está en uso.",
            "username.regex" => "El nombre de usuario solo puede contener letras, números, guiones y guiones bajos.",
            "email.required" => "El email es obligatorio.",
            "email.email" => "El email debe ser válido.",
            "email.unique" => "Este email ya está registrado.",
            "password.required" => "La contraseña es obligatoria.",
            "password.min" => "La contraseña debe tener al menos 6 caracteres.",
            "password.confirmed" => "Las contraseñas no coinciden.",
        ]);

        // Crear el usuario en la base de datos y hashear la contraseña antes de guardarla
        $usuario = User::create([
            "name" => $datos["name"],
            "username" => $datos["username"],
            "email" => $datos["email"],
            "password" => Hash::make($datos["password"]),
        ]);

        // Iniciar sesión automáticamente después del registro
        auth()->login($usuario);

        $redirectTo = $this->sanitizeRedirectTo($peticion->input('redirect_to'));
        if ($redirectTo && $this->isSameHostRedirect($redirectTo, $peticion)) {
            return redirect($redirectTo)->with("success", "Cuenta creada exitosamente. ¡Bienvenido!");
        }

        return redirect()->route("catalogo")->with("success", "Cuenta creada exitosamente. ¡Bienvenido!");
    }

    private function sanitizeRedirectTo(?string $redirectTo): ?string
    {
        if (!$redirectTo) {
            return null;
        }

        $parsed = parse_url($redirectTo);
        if ($parsed === false) {
            return null;
        }

        parse_str($parsed['query'] ?? '', $query);
        unset($query['ajax']);
        unset($query['page']);

        $path = isset($parsed['scheme'])
            ? ($parsed['scheme'] . '://' . $parsed['host'] . (isset($parsed['port']) ? ":{$parsed['port']}" : '') . ($parsed['path'] ?? ''))
            : ($parsed['path'] ?? '/');

        $queryString = http_build_query($query);
        return $queryString ? $path . '?' . $queryString : $path;
    }

    private function isSameHostRedirect(string $redirectTo, Request $peticion): bool
    {
        $parsedHost = parse_url($redirectTo, PHP_URL_HOST);
        return $parsedHost === null || $parsedHost === $peticion->getHost();
    }
}