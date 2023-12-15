<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class ApprovalConfirmationHotel extends Notification
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
        return (new MailMessage)->view(  'emails.' . $locale . '.approved-partner', [ 'name' => $data['name'],  'hotelName' => $data['hotel_name'], 'checkinCustomer' => $data['checkin_customer'], 'checkoutCustomer' => $data['checkout_customer'], 'price' => $data['price'], 'code' => $data['code'], 'dayNamedDate' => $data['day_named_date'], 'priceTotal' => $data['price_total'], 'person' => $data['person'], 'children' => $data['children'], 'route' => $data['route_customer'], 'routePaynow' => $data['route_paynow'] ] )
        ->subject(trans('txt.mail_booking_confirmed_hotel') );

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
