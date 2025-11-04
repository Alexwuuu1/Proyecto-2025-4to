<?php

namespace App\Notifications;

use App\Models\Activity;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewActivityNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Activity $activity;

    /**
     * Create a new notification instance.
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
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
                    ->subject('Nueva Actividad Disponible - UNIFRANZ')
                    ->greeting('¡Hola ' . $notifiable->name . '!')
                    ->line('Se ha publicado una nueva actividad de voluntariado:')
                    ->line('**' . $this->activity->name . '**')
                    ->line($this->activity->description)
                    ->line('Estado: ' . ucfirst($this->activity->status))
                    ->action('Ver Actividad', url('/activities/' . $this->activity->id))
                    ->line('¡Esperamos tu participación!')
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
            'activity_id' => $this->activity->id,
            'activity_name' => $this->activity->name,
            'message' => 'Nueva actividad disponible: ' . $this->activity->name,
        ];
    }
}
