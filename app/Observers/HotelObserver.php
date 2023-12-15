<?php

namespace App\Observers;

use App\Models\Hotels;
use StripeChannel, DiscordRoom;

class HotelObserver
{
    public $stripeAPI;
    public $discord;

    public function __construct()
    {
        $this->stripeAPI = new StripeChannel;
        $this->discord = new DiscordRoom(['token' => Config::get('services.discord.token')]);
//        $this->stripeAPI = new StripeAPIAdvanced();
//        $this->discord = new DiscordClient(['token' => 'NzczMDk1MDYyMTI5MjEzNDcy.X6EO4g.WC2gPo-DQAW8SN8yn8Nx37AKR4Y']);
    }

    public function created(Hotels $hotel)
    {

    }

    public function updated(Hotels $hotel)
    {
/*
        $product = $this->stripeAPI->saveProduct($hotel);
        $price = $this->stripeAPI->createPrice($product['id'], $hotel->price);
        $hotel->stripe_data = [
            'product_sid' => $product['id'],
            'price_sid'   => $price['id']
        ];
        $hotel->save();
        $this->discord->channel->createMessage([
            'channel.id' => HotelObserver::ROOM,
            'content' => 'Product updated with ID: '.$product_id.' and price ID: '.$price_id
        ]);
*/

    }

    public function deleted(Hotels $hotel)
    {
        //
    }

    public function restored(Hotels $hotel)
    {
        //
    }

    public function forceDeleted(Hotels $hotel)
    {
        //
    }
}
