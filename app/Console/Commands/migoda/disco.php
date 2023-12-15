<?php

namespace App\Console\Commands\migoda;

use Illuminate\Console\Command;
use Schema, Config, Carbon\Carbon, DB, Artisan, App\Helpers;
use App\Models\Reservoir, App\Models\Hotels, App\Models\Cities, App\Models\Countries, App\Models\RawData;
use Google\Auth, App\Util\GoogleDrive, App\Util\GoogleSheets;
use Revolution\Google\Sheets\Sheets, Google_Client, Google_Service_Sheets;
use Symfony\Component\Console\Output\BufferedOutput;
use DiscordRoom, App\Traits\DiscordTrait;

class disco extends Command
{
    use DiscordTrait;

    protected $signature = 'migoda:disco:partizane {q?}';
    protected $description = 'Discord Bot to handle all discord commands';

    public function __construct()
    {
        parent::__construct();
        if (DB::connection()->getDatabaseName()) {
            $check = Schema::hasTable('countries');
            if ($check) {
                $this->allCountries = (array) Countries::select('name')->get()->pluck('name');
                $this->allCountries = array_filter(Helpers::array_flatten($this->allCountries), fn($v) => !is_null($v) && $v !== '');
//                $this->discord = new DiscordRoom(['token' => Config::get('services.discord.token')]);
            }
        }
        parent::__construct();
    }

    public function handle()
    {
        $byPass = ($this->argument('q') !== '') ? [['content' => $this->argument('q')]] : [];
        $lastMessage = (int) Reservoir::select('vval')->where('vkey', 'bot.lastMessage')->get()->pluck('vval')->first();
//        $room = $this->discordRoom(Config::get('services.discord.room'));
//        var_dump($room);

        Reservoir::updateOrCreate(['vkey' => 'bot.lastMessage'], ['vval' => (int)$room->last_message_id]);

//        $msgs = $this->discordReadMessages($lastMessage);
        $byPass = ($this->argument('q') !== '') ? [['content' => $this->argument('q')]] : [];
        $msgs = ($this->argument('q') && count($byPass) > 0) ? $byPass : $msgs;

        foreach ($msgs as $msg) {
            if (in_array(((int)$msg->author['id']), $roomOps)) {

                if (substr($msg->content, 0, 1) === '/') {
                    $split = explode(' ', $msg->content);
                    switch ($split[0]) {
                        case '/cmds':
/*
                            $this->discordMessage([
                                [
                                    'name' => "/burst",
                                    'value' => "starts writing all GoogleSheets entries onto the active database."
                                ], [
                                    'name' => "/stripe [info|filter] [events|dates] [parameters] [mail]",
                                    'value' => "lists succeeded Stripe events by filters &/ displays its details."
                                ], [
                                    'name' => "/coupon [number] [prefix] [suffix] [name]",
                                    'value' => "creates new coupons for Migoda."
                                ],
                            ], [
                                'type' => "Bot commands", 
                                'description' => "",
                                'title' => "available commands: (use help for more details on each)",
                                'color' => 'ORANGE',
                            ]);
*/
                            break;
                        case '/burst':
                            switch ($split[1]) {
                                // /burst write [country_name]
                                case 'write':
                                    Artisan::call('migoda:burstWrite', ($split[2]) ? ['country' => $split[2]] : []);
                                    break;
                                case 'help':
                                default:
/*
                                    $this->discordMsg('/burst [country]');
                                    $this->discordMsg('starts writing all GoogleSheets entries onto the active database.');
                                    $this->discordMsg('(If country/countrycode is specified, it only writes the specified entries.)');
*/
                                    break;
                            }
                            break;
                        case '/stripe':
                            // stripe balance|transactions|help|filter by-event|by-date parameters mail
                            // stripe balance/[b] retrieve
                            // stripe transactions/[x] all
                            // stripe transactions/[x] retrieve [id]
                            // stripe help/[h]
                            switch ($split[1]) {
                                case 'br':
                                    Artisan::call('stripper:balance:retrieve', []);
                                    $callOut = preg_split('/\r\n|\r|\n/', Artisan::output());
                                    break;
                                case 'xa':
                                    Artisan::call('stripper:balance:trans:all', []);
                                    break;
                                case 'xr':
                                    Artisan::call('stripper:balance:trans:retrieve', $split[2]);
                                    break;
                                case 'create':
                                    break;
                                case 'b':
                                case 'balance':
                                    switch ($split[2]) {    // 
                                        case 'retrieve':
                                            Artisan::call('stripper:balance:retrieve', []);
                                            break;
                                    }
                                    break;
                                case 'x':
                                case 'transactions':
                                    switch ($split[2]) {
                                        case 'all':         // stripper:balance:trans:all
                                            Artisan::call('stripper:balance:trans:all', []);
                                            break;
                                        case 'retrieve':    // stripper:balance:trans:retrieve {id}
                                            Artisan::call('stripper:balance:trans:retrieve', $split[3]);
                                            break;
                                    }
                                    break;
                                case 'h':
                                case 'help':
                                default:
//                                    $this->discordMsg('/stripe [info|filter] [events|dates] [parameters] [mail]');
//                                    $this->discordMsg('lists succeeded Stripe events by filters &/ displays its details.');
                                    break;
                            }
                            $this->discordMsg($callOut, [
                                'type' => "Coupons", 
                                'title' => "Generated coupons",
                                'color' => 'GREEN', 
                            ]);
                            break;
                        case '/coupon':
                            // help|make|list|delete name prefix suffix number
                            switch ($split[1]) {
                                case 'make':
                                    // coupon make {num?} {--pre=abc} {--suf=xyz} {--name=tester}
                                    Artisan::call('migoda:create:coupon', [
                                        'num' => (count($split) > 2) ? $split[2] : 3,
                                        '--pre' => (count($split) > 3) ? $split[3] : 'abc',
                                        '--suf' => (count($split) > 4) ? $split[4] : 'xyz',
                                        '--name' => (count($split) >= 5) ? $split[5] : 'Tester',
                                    ]);
                                    $callOut = preg_split('/\r\n|\r|\n/', Artisan::output());
//                                    dd(Helpers::hex_dump($callOut, ''));
                                    $lines = [];
                                    array_shift($callOut);
                                    array_walk($callOut, function (&$value) {
                                        $value = ['name' => '#', 'value' => $value, 'inline' => true];
                                    });
                                    array_pop($callOut);
/*
                                    $this->discordMsg($callOut, [
                                        'type' => "Coupons", 
                                        'color' => 'RED',
                                        'title' => "Generated coupons"
                                    ]);
*/
                                    break;
                                case 'list':
                                    break;
                                case 'delete':
                                    break;
                                case 'help':
                                default:
/*
                                    $this->discordMsg('/coupon [number] [prefix] [suffix] [name]');
                                    $this->discordMsg('creates new coupons for Migoda.');
*/
                                    break;
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
        }
        return 0;
    }
}
