<?php
namespace App\Util;

use Stripe\Stripe;
use App\Models\CouponCode;
use App\Models\Customers;
use App\Models\Hotels;
use App\Models\Countries;
use App\Models\Payments;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class webHooks
{

    $payload = @file_get_contents('php://input');
    $event = null;

    try {
        $event = \Stripe\Event::constructFrom(
            json_decode($payload, true)
        );
    } catch(\UnexpectedValueException $e) {
        // Invalid payload
        http_response_code(400);
        exit();
    }

    // Handle the event
    switch ($event->type) {
        case 'payment_intent.succeeded':
            $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
            // Then define and call a method to handle the successful payment intent.
            // handlePaymentIntentSucceeded($paymentIntent);
            break;
        case 'payment_method.attached':
            $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
            // Then define and call a method to handle the successful attachment of a PaymentMethod.
            // handlePaymentMethodAttached($paymentMethod);
            break;
        // ... handle other event types
        default:
            // Unexpected event type
            http_response_code(400);
            exit();
    }

    http_response_code(200);
}