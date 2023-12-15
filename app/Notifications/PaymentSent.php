<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;


class PaymentSent extends Notification
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
        $data = $this->data;
        return (new MailMessage)->view(  'emails.' . $locale . '.payment-sent', ['name' => $data['name'], 'price' => $data['price'], 'checkin' => $data['checkin'], 'checkout' => $data['checkout'], 'route' => $data['route'], 'res' => $data['res_id']] )
        ->subject(trans('txt.mail_payment_sent_title') );

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
