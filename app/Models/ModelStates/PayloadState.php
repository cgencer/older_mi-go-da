<?php
namespace App\Models\ModelStates;

use Spatie\ModelStates\State;

abstract class PayloadState extends State
{
    public static $states = [
        PayloadPreflight::class,
        PayloadProccessed::class,
        PayloadArchived::class,
    ];
}
