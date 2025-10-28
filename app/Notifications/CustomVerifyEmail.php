<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('🍪 Vérifiez votre compte Snackin\'')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Bienvenue chez Snackin\' ! 🍪')
            ->line('Vous recevez cet email car vous venez de créer un compte sur notre plateforme.')
            ->line('Pour commencer à passer des commandes et laisser des commentaires, veuillez vérifier votre adresse email en cliquant sur le bouton ci-dessous :')
            ->action('✅ Vérifier mon email', $verificationUrl)
            ->line('Ce lien de vérification expirera dans 60 minutes.')
            ->line('Si vous n\'avez pas créé de compte, aucune action supplémentaire n\'est requise.')
            ->salutation('À bientôt chez Snackin\' ! 🍪✨');
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
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
