<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

            $redirectTo = $this->sanitizeRedirectTo($peticion->input('redirect_to'));
            if ($redirectTo && ($this->isSameHostRedirect($redirectTo, $peticion) || Str::startsWith($redirectTo, '/'))) {
                return redirect($redirectTo)->with("success", "Sesión iniciada correctamente.");
            }

            return redirect()->route("catalogo")->with("success", "Sesión iniciada correctamente.");
        }

        return back()->withErrors(["email" => "Credenciales incorrectas."])->withInput($peticion->only("email", "redirect_to"));
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