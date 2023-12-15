<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;


class Invoice extends Notification
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
        return (new MailMessage)->view(  'emails.en.invoice', ['name' => $data['name'], 'hotel' => $data['hotel'], 'checkin' => $data['checkin'], 'checkout' => $data['checkout'], 'route' => $data['route'], 'code' => $data['res_id'], 'nights' => $data['nights'], 'hotelAddress' => $data['hotel_address'], 'nights' => $data['nights'], 'priceTax' => $data['price_tax'], 'person' => $data['person'],  'children' => $data['children'], 'dayNamedDate' => $data['day_named_date'], 'price' => $data['price'],  'priceTotal' => $data['price_total'], 'cardType' => "Visa" ,'cardLastFour' => "0405" , 'paymentDateStamp' => "Monday, 07 Jun 2021 00:21:33 ", 'totalWithTax' => $data['price_total'], 'receiptUrl' => "https://migoda.com/destinations",  'mapUrl' => "https://migoda.com/destinations" ] )
        ->subject(trans('txt.mail_invoice') );

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
