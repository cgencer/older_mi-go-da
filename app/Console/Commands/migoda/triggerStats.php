<?php

namespace App\Console\Commands\migoda;

use Illuminate\Console\Command;
use App\Jobs\BuildStats;
use Carbon\Carbon;

class triggerStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migoda:build:stats {--D|daily=} {--W|weekly=} {--M|monthly=} {--Q|quarterly=} {--Y|yearly=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build statistical data for specified intervals, if none given uses last day on each';

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
        $pars = [];
        $carb = new Carbon();
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        Carbon::setWeekEndsAt(Carbon::SUNDAY);

        if($this->option('daily')){
            $daily = $this->option('daily');
            if(is_numeric($daily)){
                $pars['d'] = $daily % 31;
            }else if(is_null($daily)){
                $pars['d'] = $carb->subDay()->day;
            }
        }
        if($this->option('weekly')){
            $weekly = $this->option('weekly');
            if(is_numeric($weekly)){
                $pars['w'] = $weekly;
            }else if(is_null($weekly)){
                $pars['d'] = $carb->subWeek()->endOfWeek()->day;
            }
        }
        if($this->option('monthly')){
            $monthly = $this->option('monthly');
            if(is_numeric($monthly)){
                $pars['m'] = $monthly % 12;
            }else if(is_null($monthly)){
                $pars['m'] = $carb->subMonth()->month;
            }
        }
        if($this->option('quarterly')){
            $quarterly = $this->option('quarterly');
            if(is_numeric($quarterly)){
                $pars['q'] = $quarterly % 4;
            }else if(is_null($quarterly)){
                $pars['q'] = $carb->subQuarter()->year;
            }
        }
        if($this->option('yearly')){
            $yearly = $this->option('yearly');
            if(is_numeric($yearly)){
                $pars['y'] = $yearly % 2030;
            }else if(is_null($yearly)){
                $pars['y'] = $carb->subYear()->year;
            }
        }
        BuildStats::dispatch($pars);
        return 0;   //else -1
    }
}
