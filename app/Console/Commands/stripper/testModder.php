<?php

namespace App\Console\Commands\stripper;

use Illuminate\Console\Command, Hash, DB, Config, Artisan, Carbon\Carbon;
use App\Models\Hotels;
use App\Models\Admins, App\Models\Customers, App\Models\User;

class testModder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripper:test:modder {q=on} {--p=123}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enables Stripe Test Mode';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $qq = explode('=', $this->argument('q'));
        $fillWith = ($qq[1]==='on') ? 'acct_1Ht8oj2RBzhAR7oQ' : null;
        $pass = Hash::make($this->option('p') ?? '123');

        if(Admins::where('email', 'cem@parsdesign.me')->get()->count() === 0){
            DB::statement("INSERT INTO admins (username, email, email_verified_at, enabled, password, last_login, firstname, lastname, phone, profile_image, date_of_birth, website, biography, gender, locale, timezone, remember_token, created_at, updated_at, email_token) VALUES('cem', 'cem@parsdesign.me', NULL, 1, '" . ('$2y$10$dwkVv2cZiw7XhjqM4y/GZuvqXLTrFH13VTsjB781v4e0mFC2OlMHS' ?? $pass) . "', '2021-01-21 10:43:28', 'Cem', 'Gencer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-01 06:35:57', '2021-01-21 10:43:28', NULL);");
        }
        if(User::where('email', 'cem@parsdesign.me')->get()->count() === 0){
            DB::statement("INSERT INTO 'users' ('uuid', 'oldID', 'name', 'username', 'email', 'email_verified_at', 'enabled', 'password', 'last_login', 'firstname', 'lastname', 'prefix', 'country', 'phone', 'profile_image', 'date_of_birth', 'website', 'biography', 'gender', 'stripe_data', 'locale', 'timezone', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'email_token') VALUES('e1d2b29d-53bb-40a5-92c0-b1a4b236c3fe', null, 'Cem', 'Gencer', 'cem@parsdesign.me', NOW(), 1, '" . $pass . "', NOW(), 'Cem', 'Gencer', NULL, NULL, '', '66a743029afba16420ee855ecf0ffa59.jpeg', NULL, NULL, NULL, 'm', NULL, 'tr_TR', 'Europe/Istanbul', NULL, NOW(), NOW(), NULL, NULL);");
        }
        if(Customers::where('email', 'cem@parsdesign.me')->get()->count() === 0){
            DB::statement("INSERT INTO 'customers' ('uuid', 'oldID', 'name', 'username', 'email', 'email_verified_at', 'enabled', 'password', 'last_login', 'firstname', 'lastname', 'prefix', 'country', 'phone', 'profile_image', 'date_of_birth', 'website', 'biography', 'gender', 'locale', 'stripe_data', 'timezone', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'email_token', 'currency', 'billing_address') VALUES('f7136f2e-2600-4f39-8024-41a86121b8cd', NULL, 'Cem', 'Gencer', 'cem@parsdesign.me', NULL, 1, '" . $pass . "', NOW(), 'Cem', 'Gencer', 970, 'TUR', '', '', '1900-1-1', NULL, NULL, 'm', NULL, NULL, NULL, NULL, NOW(), NOW(), NULL, NULL, 'eur', NULL);");
        }

        $hotels = Hotels::whereIn('country_id', [160,163,154])->get();
        $this->bar = $this->output->createProgressBar($hotels->count());
        foreach ($hotels as $hotel) {
            if(is_null($hotel->stripe_data)){
                $hotel->hotel_user()->get()->first()->stripeAccountId = $fillWith;
                Artisan::call('stripper:create:products q='.$hotel->id);
            }
            $this->bar->advance();
        }
        $this->bar->finish();    
        return 0;
    }
}
