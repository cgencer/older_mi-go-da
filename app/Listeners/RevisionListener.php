<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Traits\DiscordTrait;
use DiscordRoom;
use Illuminate\Support\Facades\Config;

class RevisionListener
{
    use DiscordTrait;
    public function __construct()
    {
//        $this->discord = new DiscordRoom(['token' => Config::get('services.discord.token')]);
//        $this->discord = new DiscordClient(['token' => 'NzczMDk1MDYyMTI5MjEzNDcy.X6EO4g.WC2gPo-DQAW8SN8yn8Nx37AKR4Y']);
    }

    public function handle($event)
    {
        // $this->discordMsg($event);
    }
}
