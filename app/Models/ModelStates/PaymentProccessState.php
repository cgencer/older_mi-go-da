<?php
namespace App\Models\ModelStates;

use Spatie\ModelStates\State;
use App\Models\ModelStates\PaymentProccessArchived;
use App\Models\ModelStates\PaymentProccessAuthorized;
use App\Models\ModelStates\PaymentProccessCancelled;
use App\Models\ModelStates\PaymentProccessCancelledGrace;
use App\Models\ModelStates\PaymentProccessCancelledHalf;
use App\Models\ModelStates\PaymentProccessCancelledRefunded;
use App\Models\ModelStates\PaymentProccessCharged;
use App\Models\ModelStates\PaymentProccessDoCharges;
use App\Models\ModelStates\PaymentProccessFailed;
use App\Models\ModelStates\PaymentProccessFees;
use App\Models\ModelStates\PaymentProccessHold;
use App\Models\ModelStates\PaymentProccessInvoiced;
use App\Models\ModelStates\PaymentProccessNoFees;
use App\Models\ModelStates\PaymentProccessPaid;
use App\Models\ModelStates\PaymentProccessPreflight;
use App\Models\ModelStates\PaymentProccessProccessed;
use App\Models\ModelStates\PaymentProccessRefunded;
use App\Models\ModelStates\PaymentProccessRequiresAction;
use App\Models\ModelStates\PaymentProccessState;
use App\Models\ModelStates\PaymentProccessStatitics;
use App\Models\ModelStates\PaymentProccessSub2;
use App\Models\ModelStates\PaymentProccessSub7;

abstract class PaymentProccessState extends State
{
    public static $states = [
        PaymentProccessArchived::class,
        PaymentProccessAuthorized::class,
        PaymentProccessCancelled::class,
        PaymentProccessCancelledGrace::class,
        PaymentProccessCancelledHalf::class,
        PaymentProccessCancelledRefunded::class,
        PaymentProccessCharged::class,
        PaymentProccessDoCharges::class,
        PaymentProccessFailed::class,
        PaymentProccessFees::class,
        PaymentProccessHold::class,
        PaymentProccessInvoiced::class,
        PaymentProccessNoFees::class,
        PaymentProccessPaid::class,
        PaymentProccessPreflight::class,
        PaymentProccessProccessed::class,
        PaymentProccessRefunded::class,
        PaymentProccessRequiresAction::class,
        PaymentProccessState::class,
        PaymentProccessStatitics::class,
        PaymentProccessSub2::class,
        PaymentProccessSub7::class,
    ];
}
