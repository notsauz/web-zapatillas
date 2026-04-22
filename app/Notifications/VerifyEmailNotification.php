<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification"s delivery channels.
     *
     * @return array<int, string>
     */
    // Especificar que la notificación se enviará por correo
    public function via(object $notifiable): array
    {
        return ["mail"];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Generar URL de verificación con ID y hash del email
        $verificationUrl = route("verification.verify", [
            "id" => $notifiable->getKey(),
            "hash" => sha1($notifiable->email)
        ]);

        // Construir el mensaje de correo con el enlace de verificación
        return (new MailMessage)
            ->subject("Verificación de Correo Electrónico - TopSneakers")
            ->greeting("¡Hola, " . $notifiable->name . "!")
            ->line("Por favor, verifica tu correo electrónico haciendo clic en el botón de abajo.")
            ->action("Verificar Correo", $verificationUrl)
            ->line("Este enlace de verificación caducará en 60 minutos.")
            ->line("Si no solicitaste crear una cuenta, ignora este email.")
            ->salutation("Saludos,TopSneakers");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
