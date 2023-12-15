<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class CancelAfter extends Notification
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
        $locale = App::getLocale();
        $data = $this->mailData;
        return (new MailMessage)->view(  'emails.' . $locale . '.cancel-after', ['checkin' => $data['checkin_date'], 'checkout' => $data['checkout_date'], 'guest' => $data['guest_name'], 'amount' => $data['amount'], 'refund' => $data['refund_date'], 'url' => $data['url']] )
        ->subject(trans('txt.mail_guest_canncellation_after'));

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
