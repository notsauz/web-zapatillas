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

        if ($peticion->ajax() || $peticion->wantsJson() || $peticion->headers->get('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(["message" => "Sesión cerrada correctamente."], 200);
        }

        $returnTo = $this->sanitizeReturnTo($peticion->input('return_to') ?? $peticion->headers->get('referer'));
        if ($returnTo && $this->isSameHostRedirect($returnTo, $peticion)) {
            return redirect($returnTo)->with("success", "Sesión cerrada correctamente.");
        }

        return redirect()->back()->with("success", "Sesión cerrada correctamente.");
    }

    private function sanitizeReturnTo(?string $returnTo): ?string
    {
        if (!$returnTo) {
            return null;
        }

        $parsed = parse_url($returnTo);
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