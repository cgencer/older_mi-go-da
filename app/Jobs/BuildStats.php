<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Stats, App\Models\Hotels, App\Models\Countries;

class BuildStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $par;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($par)
    {
/*
        $this->par = [
            'd'=> 1,
            'm' => 1,
            'w' => 1,
            'q' => 1,
            'y' => 2021
        ];
*/
        $this->par = $par;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
    }
}
