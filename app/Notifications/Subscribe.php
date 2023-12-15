<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Subscribe extends Notification
{
    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;

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
        $user = Auth::guard('customer')->user();

        $locale = App::getLocale();
        $data = $this->data;

        if ($data['type'] == 0) {
            // return (new MailMessage)->view(
            //     'emails.' . $user->language . '.unsubscribe-opened', ['name' => $data['name']]
            // );
        }else{
            return (new MailMessage)->view(
                'emails.' . $user->language . '.unsubscribe-closed', ['name' => $data['name']]
            );
        }

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
