<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class PasswordResetNotification extends Notification
{
    use Queueable;

    private $resetUrl;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($resetUrl, $lang)
    {
        $this->resetUrl = $resetUrl;
        $this->lang = $lang;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $locale = App::getLocale();
        $resetUrl = $this->resetUrl;
        return (new MailMessage)->view(
            'emails.' . $this->lang . '.forgot-password', ['resetUrl' => $resetUrl]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
