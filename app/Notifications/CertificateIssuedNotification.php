<?php

namespace App\Notifications;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CertificateIssuedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Certificate $certificate;

    /**
     * Create a new notification instance.
     */
    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Certificado de Voluntariado Emitido - UNIFRANZ')
                    ->greeting('¡Hola ' . $notifiable->name . '!')
                    ->line('¡Felicitaciones! Se ha emitido un nuevo certificado por tus horas de voluntariado.')
                    ->line('**Actividad:** ' . $this->certificate->activity_title)
                    ->line('**Horas Voluntarias:** ' . $this->certificate->hours_volunteered . ' horas')
                    ->line('**Fecha de Emisión:** ' . $this->certificate->issued_date->format('d/m/Y'))
                    ->action('Descargar Certificado', url('/certificates/' . $this->certificate->id . '/download'))
                    ->line('¡Gracias por tu compromiso con la comunidad!')
                    ->salutation('Saludos cordiales, Equipo UNIFRANZ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'certificate_id' => $this->certificate->id,
            'activity_title' => $this->certificate->activity_title,
            'hours_volunteered' => $this->certificate->hours_volunteered,
            'message' => 'Nuevo certificado emitido por ' . $this->certificate->hours_volunteered . ' horas de voluntariado.',
        ];
    }
}
