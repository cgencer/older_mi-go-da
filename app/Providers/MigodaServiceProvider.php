<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider, Illuminate\Session\SessionManager;
use Illuminate\Foundation\AliasLoader, Illuminate\Contracts\Console\Application;
use Illuminate\Console\Scheduling\Schedule, Illuminate\Contracts\Console\Kernel;
use Config, Event, Artisan, \App\Services\NormalDependency, \App\Services\SingleTonDependency;
use Illuminate\Support\Stringable;
use Stripe\Stripe, App\Util\StripeAPIAdvanced, RestCord\DiscordClient;
use Google\Auth, App\Util\GoogleDrive, App\Util\GoogleSheets;
use Revolution\Google\Sheets\Sheets, Google_Client, Google_Service_Sheets;
use App\Util\GoogleDrive as GD, App\Util\GoogleSheets as GS, App\Util\GoogleSheetsRequestCache as GSRQ;
use App\Models\GlobalSettings, App\Helpers;
use StripeChannel, DiscordRoom, App\Traits\DiscordTrait;
use App\Listeners\StripeGeneratorListener, App\Listeners\StripeWebhookListener, App\Listeners\AsyncHookListener;
use App\Listeners\UserListener, App\Listeners\HotelListener, App\Listeners\AlertListener, App\Listeners\PaymentStatusListener;
use App\Events\StatusSync, App\Events\StripeGenerator, App\Events\AlertMessages, App\Events\CustomerCreated;
use App\Events\HotelUpdated, App\Events\UserUpdated;
use Enqueue\Dbal\DbalConnectionFactory, Enqueue\Dbal\ManagerRegistryConnectionFactory, Doctrine\Persistence\ManagerRegistry;
use Enqueue\SimpleClient\SimpleClient, Interop\Queue\Message, Interop\Queue\Processor;

class MigodaServiceProvider extends ServiceProvider
{
//    use DiscordTrait;

    protected $defer = false;
    protected $console_commands = [];

    const SHEETID = 'services.google.sheets.sheet_id';
    const DISCOTOKEN = 'services.discord.token';
    const STRIPESECRET = 'services.stripe.secret';

    public function boot()
    {
        Stripe::setApiKey(config(self::STRIPESECRET));
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $this->scheduleInDayCommands($schedule);
            $this->scheduleDailyCommands($schedule);
            $this->scheduleOnDayCommands($schedule);
        });
    }

    public function register()
    {
        $this->app->singleton(GlobalSettings::class, function ($app) {
            return new GlobalSettings(Setting::all());
        });


        $this->app->singleton(Helpers::class, function ($app) {
            return new Helpers();
        });
        $this->app->alias('Helpers', \App\Helpers::class);


        $this->app->alias('StripeCustomer', \App\Models\Stripe\StripeCustomer::class);
        $this->app->alias('StripeProduct', \App\Models\Stripe\StripeProduct::class);
        $this->app->alias('StripeAccount', \App\Models\Stripe\StripeAccount::class);


        $this->app->singleton(StripeAPIAdvanced::class, function ($app) {
            return new StripeAPIAdvanced();
        });
        $this->app->singleton(DiscordClient::class, function ($app) {
            return new DiscordClient(['token' => Config::get(self::DISCOTOKEN)]);
        });


        $loader = AliasLoader::getInstance();
        $loader->alias('DiscordRoom', DiscordClient::class);
        $loader->alias('StripeChannel', StripeAPIAdvanced::class);


        $this->app->singleton(GoogleDrive::class, function ($app) {
            return new GD();
        });
        $this->app->alias('GDrive', GoogleDrive::class);

        $this->app->singleton(GoogleSheets::class, function ($app) {
            return new GS(Config::get(self::SHEETID));
        });
        $this->app->alias('GSheets', GoogleSheets::class);
        $this->app->singleton(GoogleSheetsRequestCache::class, function ($app) {
            return new GSRC();
        });
        $loader->alias('GStack', GoogleSheetsRequestCache::class);
        $loader->alias('GDrive', GoogleDrive::class);
        $loader->alias('GSheets', GoogleSheets::class);

        $this->loadCommands('Console/Commands');

        $stripeClient = new StripeChannel;
        $hooks = $stripeClient->endPoints();

//        $factory = new DbalConnectionFactory('mysql://'.env('DB_USERNAME').':'.env('DB_PASSWORD').'@'.env('DB_HOST').':'.env('DB_PORT').'/'.env('DB_DATABASE'));

/*        $factory = new ManagerRegistryConnectionFactory($registry, [
            'connection_name' => 'default',
        ]);
*/
//        $context = (new \Enqueue\ConnectionFactoryFactory())->create('mysql:')->createContext();

//        $factory = new DbalConnectionFactory('mysql:');
/*
        $conn = 'mysql://'.env('DB_USERNAME').':'.env('DB_PASSWORD').'@'.env('DB_HOST').':'.env('DB_PORT').'/'.env('DB_DATABASE');
        $factory = new DbalConnectionFactory($conn);
        $context = $factory->createContext();

        $fooTopic = $context->createTopic('aTopic');
        $message = $context->createMessage('Hello world!');

//        $context->createProducer()->send($fooTopic, $message);
*/
        foreach ($hooks as $hook) {
            Event::listen('stripe-webhooks::' . $hook, StripeWebhookListener::class);
        }

        Event::listen(UserUpdated::class, UserListener::class);
        Event::listen(HotelUpdated::class, HotelListener::class);

        Event::listen(CustomerCreated::class, CustomerListener::class);
        Event::listen(StatusSync::class, PaymentStatusListener::class);
        Event::listen(StripeGenerator::class, StripeGeneratorListener::class);
    }

    public function provides()
    {
        return [
            DiscordClient::class, 'DiscordRoom',
            StripeAPIAdvanced::class, 'StripeClient',
            GoogleDrive::class, 'GDrive',
            GoogleSheets::class, 'GSheets',
            Helpers::class, 'Helpers',
        ];
    }

    protected function loadCommands($path)
    {
        $realPath = app_path($path);
        $cmds = [];

        collect(scandir($realPath))
            ->each(function ($item) use ($path, $realPath) {
                if (in_array($item, ['.', '..', '.DS_Store'])) return;

                if (is_dir($realPath . '/' . $item)) {
                    $this->loadCommands($path . '/' . $item . '/');
                }

                if (is_file($realPath . '/' . $item)) {
                    $item = str_replace('.php', '', $item);
                    $class = str_replace('/', '\\', "\App\\{$path}$item");
                    $class = str_replace('\\\\', '\\', $class);
                    if (class_exists($class)) {
                        $this->console_commands[] = $class;
                    }
                    $this->commands($this->console_commands);
                }
            });
    }


    protected function scheduleInDayCommands(Schedule &$schedule)
    {

        $countries = config('services.google.sheets.sheet_countries');
        foreach ($countries as $country) {
            $schedule->command('migoda:task:sheets2db ' . $country)
                ->timezone('Europe/Berlin')->environments('production')
                ->runInBackground()->evenInMaintenanceMode()->withoutOverlapping()
                ->onSuccess(function () use ($country) {
                    /*
                                        $this->discord = new DiscordRoom(['token' => Config::get('services.discord.token')]);
                                        $this->discord->channel->createMessage([
                                            'channel.id' => (int) config('services.discord.room'),
                                            'content'    => '> initiated sync for ' . $country .
                                                            ' on: ' . Config::get('app.env') .
                                                            ' / db: ' . Config::get('database.connections.mysql.database')
                                        ]);
                    */
                })->onFailure(function (Stringable $output) {

                })->everyFiveMinutes();

        }
        /*
            $schedule->command('order:not-responded-check')->everyFiveMinutes();
            $schedule->command('order:confirm-partners')->hourly();
            $schedule->command('order:generate:statistic')->everyThirtyMinutes();
                $schedule->command('products:set-rating')->dailyAt('02:30');
                $schedule->command('service:generators:sitemap')->dailyAt('00:35');
                $schedule->command('send:daily-emails')->dailyAt('00:00');
                $schedule->command('service:log:clear')->dailyAt('04:15');
                $schedule->command('order:auto-close')->dailyAt('02:05');
                $schedule->command('promo-code-sms:send')->dailyAt('12:00');
        */
    }

    protected function scheduleDailyCommands(Schedule &$schedule)
    {

        $schedule->command('migoda:build:stats --daily')
            ->timezone('Europe/Berlin')->environments('production')
            ->runInBackground()->evenInMaintenanceMode()->withoutOverlapping()
            ->onSuccess(function () {

            })->onFailure(function (Stringable $output) {

            })->dailyAt('01:00');

        $schedule->command('migoda:task:sheetsBackup')
            ->timezone('Europe/Berlin')->environments('production')
            ->runInBackground()->evenInMaintenanceMode()->withoutOverlapping()
            ->onSuccess(function () {
                Log::warning('generated backup on google...');
            })->onFailure(function (Stringable $output) {
                Log::error('generated error:' . $output);
            })->dailyAt('05:00');
    }

    protected function scheduleOnDayCommands(Schedule &$schedule)
    {
        // commands that run on certain days

        $schedule->command('migoda:build:stats --weekly')
            ->timezone('Europe/Berlin')->environments('production')
            ->runInBackground()->evenInMaintenanceMode()->withoutOverlapping()
            ->onSuccess(function () {

            })->onFailure(function (Stringable $output) {

            })->weeklyOn(7, '3:00');

        $schedule->command('migoda:build:stats --monthly')
            ->timezone('Europe/Berlin')->environments('production')
            ->runInBackground()->evenInMaintenanceMode()->withoutOverlapping()
            ->onSuccess(function () {

            })->onFailure(function (Stringable $output) {

            })->monthlyOn(1, '4:00');


        $schedule->command('migoda:build:stats --quarterly')
            ->timezone('Europe/Berlin')->environments('production')
            ->runInBackground()->evenInMaintenanceMode()->withoutOverlapping()
            ->onSuccess(function () {

            })->onFailure(function (Stringable $output) {

            })->quarterly();

        $schedule->command('migoda:build:stats --yearly')
            ->timezone('Europe/Berlin')->environments('production')
            ->runInBackground()->evenInMaintenanceMode()->withoutOverlapping()
            ->onSuccess(function () {

            })->onFailure(function (Stringable $output) {

            })->yearly();
    }

}
