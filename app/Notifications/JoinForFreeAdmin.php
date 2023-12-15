<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JoinForFreeAdmin extends Notification
{
    use Queueable;

    private $mailData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

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
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailData = $this->mailData;
        return (new MailMessage)->view(
            'emails.'. $mailData['language'] .'.join-for-free-admin', ['name' => $mailData['fullName'], 'email' => $mailData['email'], 'hotelName' => $mailData['hotelName'], 'hotelAddress' => $mailData['hotelAddress'], 'phone' => $mailData['phone'], 'website' => $mailData['website']]
        );
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
            //
        ];
    }
}
