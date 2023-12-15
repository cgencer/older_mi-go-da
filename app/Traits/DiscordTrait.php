<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Config, DiscordRoom;

Trait DiscordTrait
{
    protected $room;
    protected $RoomOps = [517766531493396500, 688760324983488543, 689837708650217478, 
                          687737808391110698, 352930193528193026];
    protected $colors = [
        'RED'           => 15158332,
        'GREEN'         => 3066993,
        'BLUE'          => 3447003,
        'ORANGE'        => 15105570,
        'GREY'          => 9807270,
        'NAVY'          => 3426654,
        'GOLD'          => 1752220,
        'AQUA'          => 15158332,
        'LIGHT_GREY'    => 12370112,
        'DARK_GREY'     => 9936031,
        'DARKER_GREY'   => 8359053
    ];
    protected $base = [
        'title'         => '',
        'description'   => '',
        'color'         => '',
        'timestamp'     => '',
        'footer'        => [
            'icon_url'  => "",          // footer-left thumbnail
            'text'      => "Migoda, ready for your pleasures..."
        ],
        'thumbnail'     => [            // right-side image
            'url'       => 'https://media3.giphy.com/media/oO8KZqecXs7pmNxFux/giphy.gif'
        ],
        'image'         => [            // left-side
            'url'       => "https://beta.migoda.com/front/assets/images/logo-header.png"
        ],
        'author'        => [
            'name'      => '',
            'url'       => 'https://beta.migoda.com',
            'icon_url'  => "https://beta.migoda.com/front/assets/images/logo-header.png"
        ],
        'fields'        => []
    ];

    public function __construct()
    {
        $this->room = (int) config('services.discord.room');
    }

    public function discordMsg($msg, $pack = null)
    {
        $this->discord = $this->discord ?? new DiscordRoom(['token' => Config::get('services.discord.token')]);

        $cleanedLines = [];
        if(!is_integer($this->room)){
            $this->room = (int) Config::get('services.discord.room');
        }
        if(is_array($msg)){
            foreach ($msg as $item) {
                if(is_array($item)){
                    if( array_key_exists('name', $item) && is_string($item['name']) &&strlen($item['name']>0) &&
                        array_key_exists('value', $item) && is_string($item['value']) && strlen($item['value']>0)
                    ){
                        $cleanedLines[] = $item;
                    }
                }else if(is_string($item)){
                    $cleanedLines[] = [
                        'name' => '...:::| \Y/ |:::...',
                        'value'=> $item
                    ];
                }
            }
            $this->discord->channel->createMessage($this->discordFormat($pack, $msg));

        }else if(is_string($msg)){
            $this->discord->channel->createMessage([
                'channel.id'    => $this->room, 
                'content'       => $msg
            ]);
        }
    }

/*
channel.id          snowflake       true    null
content             string          false   null

nonce               snowflake       false   null
tts                 boolean         false   null
file                file contents   false   null
embed               object          false   null
payload_json        string          false   null
*/
    public function discordReadMessages($lm)
    {
        $msgs = $this->discord->channel->getChannelMessages([
            'channel.id' => config('services.discord.room'),
            'after' => $lm
        ]);
        return $msgs;
    }

    public function discordRoom($roomid)
    {
        return $this->discord->channel->getChannel(['channel.id' => $roomid]);
    }

    public function discordRoomMembers($roomid)
    {
        $out = [];
        $room = $this->discordRoom($roomid);
        foreach ($room->permission_overwrites as $key => $user) {
            try {
                if($user->type === 'member')
                $out[] = $this->discord->user->getUser(['user.id'=>(int)$user->id])->id . ' ::: ' . $this->discord->user->getUser(['user.id'=>(int)$user->id])->username;
            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
        return $out;
    }

    public function discordFormat($pack, $lines)
    {
        $base = $this->base;
        $base['title']          = $pack['title'];
        $base['description']    = $pack['description'];
        $base['color']          = $this->colors[ $pack['color']];
        $base['title']          = \Carbon\Carbon::now()->toDateTimeString();
        $base['author']['name'] = $pack['author'] ?? $pack['type'];
        $base['fields']         = $lines;

        return [
            "channel.id" => $this->room,
            "content"    => "   ",
            "embed"      => array_merge($base, ($lines ?? []))
        ];
    }
}