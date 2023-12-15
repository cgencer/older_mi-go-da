<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable, Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage, Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel, NotificationChannels\Discord\DiscordMessage;

class DiscordNotifications extends Notification
{
    use Queueable;

    public $challenger;
    public $game;

    public function __construct(Guild $challenger, Game $game)
    {
        $this->challenger = $challenger;
        $this->game = $game;
    }

    public function via($notifiable)
    {
        return [DiscordChannel::class];
    }

    public function toDiscord($notifiable)
    {
        return DiscordMessage::create("You have been challenged to a game of *{$this->game->name}* by **{$this->challenger->name}**!");
    }

}
