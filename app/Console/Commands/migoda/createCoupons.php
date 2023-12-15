<?php

namespace App\Console\Commands\migoda;

use Illuminate\Console\Command;
use App\Models\CouponCode, App\Models\CouponRule, App\Models\CouponUsage;
use Config, DB, App\Helpers, Carbon\Carbon;

class createCoupons extends Command
{
    protected $signature = 'migoda:create:coupon {--num=10} {--pre=abc} {--suf=xyz} {--name=tester} {--belongs=1} {--addTo=} {--from=} {--to=}';
    protected $description = 'Create coupon blocks';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (DB::connection()->getDatabaseName()) {
            $newRule = new \App\Models\CouponRule();
            $newRule->name = $this->option('name') ? $this->option('name') : $this->ask('Rule Adı:', 'Tester');
            $newRule->prefix = $this->option('pre') ? $this->option('pre') : $this->ask('prefix:', 'abc');
            $newRule->suffix = $this->option('suf') ? $this->option('suf') : $this->ask('suffix:', 'xyz');
            $newRule->quantity = $this->option('num') ? $this->option('num') : $this->ask('Kaç adet kupon eklensin:', 10);
            $newRule->is_active = 1;
            $newRule->generate = 1;
            $newRule->length = 12;
            $now = Carbon::now();
            $from = new Carbon($this->option('from'));
            $to = new Carbon($this->option('to'));
            $newRule->start_date = $this->option('from') ? $from->midDay() : $now;
            $newRule->end_date = $this->option('to') ? $to->midDay() : $now->addDays(30)->midDay();
            $newRule->save();
            if ($newRule) {
                for ($i = 0; $i < $newRule->quantity; $i++) {
                    $newCoupon = new \App\Models\CouponCode();
                    $newCoupon->rule_id = $newRule->id;
                    $newCoupon->code = Helpers::getAvailableCouponCode($newRule->prefix, $newRule->suffix, $newRule->length);
                    $newCoupon->save();

                    if($this->option('addTo')){
                        $addCoupon = new CouponUsage();
                        $addCoupon->code = $newCoupon->code;
                        $addCoupon->rule_id = $newCoupon->rule_id;
                        $addCoupon->customer_id = $this->option('addTo');
                        $addCoupon->save();
                    }
                }
                $this->info('new coupons arrived, sire:');
                $coup = \App\Models\CouponCode::getCoupons($newRule->name);
                foreach ($coup as $item) {
                    $this->line($item->code);
                }
            }
        }
    }
}
