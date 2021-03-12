<?php

namespace Marketplace\Core\Auth\Reset;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Marketplace\Core\Type\TypeService;

class SendResetNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  User  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(User $notifiable)
    {
        return (new MailMessage)
                    ->line('Password reset.')
                    ->action(
                        'Reset',
                        URL::signedRoute(
                            'marketplace.core.auth.password', [
                                'type' => TypeService::getKeyByClass($notifiable->getAttribute('type')),
                                'id' => $notifiable->getAuthIdentifier()
                            ],
                            Carbon::now()->addDays(2)
                        )
                    )
                    ->line('Expiration in 48h.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data' => [
                'message' => 'Registration',
                'registration_url' => URL::signedRoute(
                    'marketplace.core.auth.verify', [
                        'id' => $notifiable->getAuthIdentifier()
                    ],
                    Carbon::now()->addDays(2)
                ),
                'info' => 'Expiration in 48h',
            ]
        ];
    }
}
