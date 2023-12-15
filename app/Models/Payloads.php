<?php

namespace App\Models;

use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\HasStates;
use App\Models\ModelStates\PayloadPreflight;
use App\Models\ModelStates\PayloadProccessed;
use App\Models\ModelStates\PayloadArchived;

class Payloads extends Model
{
    use Uuids, SoftDeletes, HasStates;

    protected $table = 'webhook_calls';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'payload' => 'array',
        'exception' => 'array'
    ];

    protected function registerStates(): void
    {
        try {
            $this->addState('status', PayloadState::class)
                ->default(PayloadPreflight::class)
                ->allowTransition(PayloadPreflight::class, PayloadProccessed::class)
                ->allowTransition(PayloadProccessed::class, PayloadArchived::class);
        } catch (InvalidConfig $e) {
        }
    }

}
