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
    /**
     * Mostrar la página de favoritos
     */
    public function favorites(Request $request)
    {
        $user = auth()->user();
        $query = $user->favoriteSneakers()->with('brandModel');
        $sneakers = $query->paginate(12);

        $favoriteSneakerIds = auth()->check()
            ? $user->favoriteSneakers()->pluck('sneakers.id')->toArray()
            : [];

        if ($request->ajax() || $request->get('ajax')) {
            return response()->json([
                'html' => view('sneakers.partials.grid', compact('sneakers', 'favoriteSneakerIds'))->render(),
                'hasMore' => $sneakers->hasMorePages(),
                'currentPage' => $sneakers->currentPage(),
            ]);
        }

        return view('profile.favorites', compact('sneakers', 'favoriteSneakerIds'));
    }

    /**
     * Mostrar el formulario de edición de perfil
     */
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Actualizar la información del perfil (nombre y email)
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
        ]);

        // Si el email está verificado, no permitir cambios
        if ($user->email_verified_at && $validated['email'] !== $user->email) {
            return redirect()->route('profile.edit')
                ->with('error', 'No puedes cambiar tu email porque ya está verificado. Si necesitas cambiar tu email, contacta con soporte.');
        }

        $user->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Cambiar contraseña
     */
    public function changePassword(Request $request)
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Validar la contraseña actual y la nueva contraseña
        $validated = $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('La contraseña actual es incorrecta.');
                    }
                },
            ],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'different:current_password',
            ],
            'new_password_confirmation' => 'required',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'new_password.required' => 'La nueva contraseña es obligatoria.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'Las contraseñas nuevas no coinciden.',
            'new_password.different' => 'La nueva contraseña debe ser diferente a la actual.',
        ]);

        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        // Cerrar sesión por seguridad
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigir al login con mensaje de éxito
        return redirect()->route('login')
            ->with('success', 'Contraseña actualizada correctamente. Por favor inicia sesión de nuevo.');
    }

    /**
     * Enviar email de verificación
     */
    public function sendVerificationEmail(Request $request)
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Si el email ya está verificado
        if ($user->email_verified_at) {
            return redirect()->route('profile.edit')
                ->with('info', 'Tu correo electrónico ya está verificado.');
        }

        // Enviar notificación
        $user->notify(new VerifyEmailNotification());

        // Redirigir con mensaje de éxito
        return redirect()->route('profile.edit')
            ->with('success', 'Email de verificación enviado a ' . $user->email . '. Revisa tu bandeja de entrada.');
    }

    /**
     * Verificar email (ruta callback)
     */
    public function verifyEmail(Request $request, $id, $hash)
    {
        // Log para depuración
        Log::info('Intento de verificación de email', [
            'user_id' => $id,
            'hash_recibido' => $hash,
        ]);

        // Buscar el usuario por ID
        try {
            $user = User::findOrFail($id);
            Log::info('Usuario encontrado', ['email' => $user->email]);

            // Si ya está verificado, avisar
            if ($user->email_verified_at) {
                Log::info('Email ya verificado');
                return redirect()->route('profile.edit')
                    ->with('info', 'Tu correo electrónico ya estaba verificado.');
            }

            // Calcular el hash esperado
            $hash_esperado = sha1($user->email);
            Log::info('Validación de hash', [
                'hash_recibido' => $hash,
                'hash_esperado' => $hash_esperado,
                'email_user' => $user->email,
                'hash_match' => $hash === $hash_esperado,
            ]);

            // Validar el hash
            if ($hash !== $hash_esperado) {
                Log::error('Hash no coincide');
                return redirect()->route('profile.edit')
                    ->with('error', 'El enlace de verificación es inválido o ha expirado.');
            }

            // Marcar como verificado
            $resultado = $user->update([
                'email_verified_at' => now(),
            ]);

            // Log del resultado de la actualización
            Log::info('Email verificado correctamente', [
                'user_id' => $user->id,
                'email_verified_at' => $user->fresh()->email_verified_at,
                'update_result' => $resultado,
            ]);

            // Redirigir con mensaje de éxito
            return redirect()->route('profile.edit')
                ->with('success', 'Tu correo electrónico ha sido verificado correctamente.');

            // Manejo de excepciones
        } catch (\Exception $e) {
            Log::error('Error en verificación de email', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            // Redirigir con mensaje de error
            return redirect()->route('profile.edit')
                ->with('error', 'Error al verificar el correo: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar la cuenta del usuario (primera confirmación)
     */
    public function deleteAccount(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('La contraseña es incorrecta.');
                    }
                },
            ],
        ], [
            'password.required' => 'Debes ingresar tu contraseña para continuar.',
        ]);

        // Guardar el ID del usuario en sesión para la segunda confirmación
        session(['delete_account_confirmed' => true, 'delete_account_id' => $user->id]);

        // Redirigir con mensaje de advertencia para confirmar eliminación
        return redirect()->route('profile.edit')
            ->with('warning', 'Confirmación pendiente: Haz clic en "CONFIRMAR ELIMINACIÓN" para borrar permanentemente tu cuenta.');
    }

    /**
     * Confirmar y ejecutar la eliminación de la cuenta (segunda confirmación)
     */
    public function confirmDelete(Request $request)
    {
        // Validar que el usuario confirmó la contraseña
        if (!session('delete_account_confirmed') || session('delete_account_id') !== auth()->id()) {
            return redirect()->route('profile.edit')
                ->with('error', 'Debes completar la confirmación de contraseña primero.');
        }

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Limpiar sesión
        session()->forget(['delete_account_confirmed', 'delete_account_id']);

        // Cerrar sesión
        auth()->logout();

        // Eliminar la cuenta
        $user->delete();

        // Invalidar sesión y regenerar token por seguridad
        session()->invalidate();
        session()->regenerateToken();

        // Redirigir al login con mensaje de éxito
        return redirect()->route('login')
            ->with('success', 'Tu cuenta ha sido eliminada permanentemente. Lamentamos verte partir.');
    }

    /**
     * Agregar zapatilla a favoritos
     */
    public function addFavorite(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'sneaker_id' => 'required|exists:sneakers,id',
        ]);

        $sneaker = \App\Models\Sneaker::find($validated['sneaker_id']);

        if ($user->favoriteSneakers()->where('sneaker_id', $sneaker->id)->exists()) {
            return redirect()->back()->with('info', 'Esta zapatilla ya está en tus favoritos.');
        }

        $user->favoriteSneakers()->attach($sneaker->id);

        return redirect()->back()->with('success', 'Zapatilla agregada a favoritos.');
    }

    /**
     * Eliminar zapatilla de favoritos
     */
    public function removeFavorite(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'sneaker_id' => 'required|exists:sneakers,id',
        ]);

        $sneaker = \App\Models\Sneaker::find($validated['sneaker_id']);

        $user->favoriteSneakers()->detach($sneaker->id);

        return redirect()->back()->with('success', 'Zapatilla eliminada de favoritos.');
    }
}
