<?php

namespace Marketplace\Core\Authentication\Verify;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Marketplace\Core\User\User;

class SendVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param User $notifiable
     *
     * @return array<string>
     */
    public function via(User $notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param User $notifiable
     *
     * @return MailMessage
     */
    public function toMail(User $notifiable)
    {
        return (new MailMessage())
            ->line('Registration.')
            ->action(
                'Confirm',
                URL::signedRoute(
                    'marketplace.core.authentication.verify',
                    [
                        'id' => $notifiable->getAuthIdentifier(),
                    ],
                    Carbon::now()->addDays(2)
                )
            )
            ->line('Expiration in 48h.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param User $notifiable
     *
     * @return array<string, array>
     */
    public function toArray(User $notifiable)
    {
        return [
            'data' => [
                'message' => 'Registration',
                'registration_url' => URL::signedRoute(
                    'marketplace.core.authentication.verify',
                    [
                        'id' => $notifiable->getAuthIdentifier(),
                    ],
                    Carbon::now()->addDays(2)
                ),
                'info' => 'Expiration in 48h',
            ],
        ];
    }
}
