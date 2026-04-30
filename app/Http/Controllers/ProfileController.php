<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Notifications\VerifyEmailNotification;
use App\Models\User;

class ProfileController extends Controller
{
    // Mostrar la lista de zapatillas favoritas del usuario con paginación y soporte para carga dinámica con AJAX
    public function favorites(Request $peticion)
    {
        $usuario = auth()->user();
        $consulta = $usuario->favoriteSneakers()->with("brandModel");
        $zapatillas = $consulta->paginate(12);

        $idsFavoritos = auth()->check()
            ? $usuario->favoriteSneakers()->pluck("sneakers.id")->toArray()
            : [];

        if ($peticion->ajax() || $peticion->get("ajax")) {
            return response()->json([
                "html" => view("sneakers.partials.grid", ["sneakers" => $zapatillas, "favoriteSneakerIds" => $idsFavoritos])->render(),
                "hasMore" => $zapatillas->hasMorePages(),
                "currentPage" => $zapatillas->currentPage(),
            ]);
        }

        return view("profile.favorites", compact("zapatillas", "idsFavoritos"));
    }

    // Mostrar el formulario de edición del perfil con los datos actuales del usuario
    public function edit()
    {
        $usuario = auth()->user();
        return view("profile.edit", compact("usuario"));
    }

    // Actualizar información del perfil con validación y mensajes personalizados y restricción para cambiar el email si ya está verificado
    public function update(Request $peticion)
    {
        $usuario = auth()->user();

        $datos = $peticion->validate([
            "name" => "required|string|max:255",
            "email" => [
                "required",
                "string",
                "email",
                "max:255",
                Rule::unique("users")->ignore($usuario->id),
            ],
        ], [
            "name.required" => "El nombre es obligatorio.",
            "name.string" => "El nombre debe ser texto.",
            "name.max" => "El nombre no puede exceder 255 caracteres.",
            "email.required" => "El email es obligatorio.",
            "email.email" => "El email debe ser válido.",
            "email.unique" => "El correo electrónico ya está registrado.",
        ]);

        // Si el email está verificado, no permitir cambios
        if ($usuario->email_verified_at && $datos["email"] !== $usuario->email) {
            return redirect()->route("profile.edit")
                ->with("error", "No puedes cambiar tu email porque ya está verificado. Si necesitas cambiar tu email, contacta con soporte.");
        }

        $usuario->update($datos);

        return redirect()->route("profile.edit")
            ->with("success", "Perfil actualizado correctamente.");
    }

    // Cambiar contraseña del usuario con validación de la contraseña actual y mensajes personalizados
    public function changePassword(Request $peticion)
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();

        // Validar la contraseña actual y la nueva contraseña
        $datos = $peticion->validate([
            "current_password" => [
                "required",
                function ($atributo, $valor, $fallo) use ($usuario) {
                    if (!Hash::check($valor, $usuario->password)) {
                        $fallo("La contraseña actual es incorrecta.");
                    }
                },
            ],
            "new_password" => [
                "required",
                "string",
                "min:8",
                "confirmed",
                "different:current_password",
            ],
            "new_password_confirmation" => "required",
        ], [
            "current_password.required" => "La contraseña actual es obligatoria.",
            "new_password.required" => "La nueva contraseña es obligatoria.",
            "new_password.min" => "La nueva contraseña debe tener al menos 8 caracteres.",
            "new_password.confirmed" => "Las contraseñas nuevas no coinciden.",
            "new_password.different" => "La nueva contraseña debe ser diferente a la actual.",
        ]);

        // Actualizar contraseña
        $usuario->update([
            "password" => Hash::make($datos["new_password"]),
        ]);

        // Cerrar sesión por seguridad
        auth()->logout();
        $peticion->session()->invalidate();
        $peticion->session()->regenerateToken();

        // Redirigir al login con mensaje de éxito
        return redirect()->route("login")
            ->with("success", "Contraseña actualizada correctamente. Por favor inicia sesión de nuevo.");
    }

    // Enviar email de verificación si el email no está verificado
    public function sendVerificationEmail(Request $peticion)
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();

        // Si el email ya está verificado
        if ($usuario->email_verified_at) {
            return redirect()->route("profile.edit")
                ->with("info", "Tu correo electrónico ya está verificado.");
        }

        // Enviar notificación
        $usuario->notify(new VerifyEmailNotification());

        // Redirigir con mensaje de éxito
        return redirect()->route("profile.edit")
            ->with("success", "Email de verificación enviado a " . $usuario->email . ". Revisa tu bandeja de entrada.");
    }

    // Verificar email (este método se llamará desde el enlace en el email de verificación)
    public function verifyEmail(Request $peticion, $id, $hash)
    {
        // Log para depuración
        Log::info("Intento de verificación de email", [
            "user_id" => $id,
            "hash_recibido" => $hash,
        ]);

        // Buscar el usuario por ID
        try {
            $usuario = User::findOrFail($id);
            Log::info("Usuario encontrado", ["email" => $usuario->email]);

            // Si ya está verificado, avisar
            if ($usuario->email_verified_at) {
                Log::info("Email ya verificado");
                return redirect()->route("profile.edit")
                    ->with("info", "Tu correo electrónico ya estaba verificado.");
            }

            // Calcular el hash esperado
            $hashEsperado = sha1($usuario->email);
            Log::info("Validación de hash", [
                "hash_recibido" => $hash,
                "hash_esperado" => $hashEsperado,
                "email_user" => $usuario->email,
                "hash_match" => $hash === $hashEsperado,
            ]);

            // Validar el hash
            if ($hash !== $hashEsperado) {
                Log::error("Hash no coincide");
                return redirect()->route("profile.edit")
                    ->with("error", "El enlace de verificación es inválido o ha expirado.");
            }

            // Marcar como verificado
            $resultado = $usuario->update([
                "email_verified_at" => now(),
            ]);

            // Log del resultado de la actualización
            Log::info("Email verificado correctamente", [
                "user_id" => $usuario->id,
                "email_verified_at" => $usuario->fresh()->email_verified_at,
                "update_result" => $resultado,
            ]);

            // Redirigir con mensaje de éxito
            return redirect()->route("profile.edit")
                ->with("success", "Tu correo electrónico ha sido verificado correctamente.");

            // Manejo de excepciones
        } catch (\Exception $e) {
            Log::error("Error en verificación de email", [
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString(),
            ]);
            // Redirigir con mensaje de error
            return redirect()->route("profile.edit")
                ->with("error", "Error al verificar el correo: " . $e->getMessage());
        }
    }

    // Eliminar cuenta (primera confirmación)
    public function deleteAccount(Request $peticion)
    {
        $usuario = auth()->user();

        $datos = $peticion->validate([
            "password" => [
                "required",
                function ($atributo, $valor, $fallo) use ($usuario) {
                    if (!Hash::check($valor, $usuario->password)) {
                        $fallo("La contraseña es incorrecta.");
                    }
                },
            ],
        ], [
            "password.required" => "Debes ingresar tu contraseña para continuar.",
        ]);

        // Guardar el ID del usuario en sesión para la segunda confirmación
        session(["delete_account_confirmed" => true, "delete_account_id" => $usuario->id]);

        // Redirigir con mensaje de advertencia para confirmar eliminación
        return redirect()->route("profile.edit")
            ->with("warning", "Confirmación pendiente: Haz clic en \"CONFIRMAR ELIMINACIÓN\" para borrar permanentemente tu cuenta.");
    }

    // Confirmar eliminación de cuenta (segunda confirmación)
    public function confirmDelete(Request $peticion)
    {
        // Validar que el usuario confirmó la contraseña
        if (!session("delete_account_confirmed") || session("delete_account_id") !== auth()->id()) {
            return redirect()->route("profile.edit")
                ->with("error", "Debes completar la confirmación de contraseña primero.");
        }

        // Obtener el usuario autenticado
        $usuario = auth()->user();

        // Limpiar sesión
        session()->forget(["delete_account_confirmed", "delete_account_id"]);

        // Cerrar sesión
        auth()->logout();

        // Eliminar la cuenta
        $usuario->delete();

        // Invalidar sesión y regenerar token por seguridad
        session()->invalidate();
        session()->regenerateToken();

        // Redirigir al login con mensaje de éxito
        return redirect()->route("login")
            ->with("success", "Tu cuenta ha sido eliminada permanentemente. Lamentamos verte partir.");
    }

    // Agregar una zapatilla a favoritos
    public function addFavorite(Request $peticion)
    {
        $usuario = auth()->user();

        $datos = $peticion->validate([
            "sneaker_id" => "required|exists:sneakers,id",
        ]);

        $zapatilla = \App\Models\Sneaker::find($datos["sneaker_id"]);

        if ($usuario->favoriteSneakers()->where("sneaker_id", $zapatilla->id)->exists()) {
            if ($peticion->ajax() || $peticion->wantsJson()) {
                return response()->json(["message" => "Esta zapatilla ya está en tus favoritos."], 200);
            }
            return redirect()->back()->with("info", "Esta zapatilla ya está en tus favoritos.");
        }

        $usuario->favoriteSneakers()->attach($zapatilla->id);

        if ($peticion->ajax() || $peticion->wantsJson()) {
            return response()->json(["message" => "Zapatilla agregada a favoritos."], 200);
        }

        return redirect()->back()->with("success", "Zapatilla agregada a favoritos.");
    }

    // Eliminar zapatilla de favoritos
    public function removeFavorite(Request $peticion)
    {
        $usuario = auth()->user();

        $datos = $peticion->validate([
            "sneaker_id" => "required|exists:sneakers,id",
        ]);

        $zapatilla = \App\Models\Sneaker::find($datos["sneaker_id"]);

        $usuario->favoriteSneakers()->detach($zapatilla->id);

        if ($peticion->ajax() || $peticion->wantsJson()) {
            return response()->json(["message" => "Zapatilla eliminada de favoritos."], 200);
        }

        return redirect()->back()->with("success", "Zapatilla eliminada de favoritos.");
    }
}