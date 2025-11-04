<?php

namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Donation $donation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
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
                    ->subject('Donación Aprobada - UNIFRANZ')
                    ->greeting('¡Hola ' . $notifiable->name . '!')
                    ->line('Tu donación ha sido aprobada exitosamente.')
                    ->line('**Monto:** Bs. ' . number_format($this->donation->amount, 2))
                    ->line('**Fecha:** ' . $this->donation->created_at->format('d/m/Y'))
                    ->line('¡Gracias por tu generoso aporte al voluntariado!')
                    ->action('Ver Mis Donaciones', url('/profile/donations'))
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
            'donation_id' => $this->donation->id,
            'amount' => $this->donation->amount,
            'message' => 'Tu donación de Bs. ' . number_format($this->donation->amount, 2) . ' ha sido aprobada.',
        ];
    }
}
