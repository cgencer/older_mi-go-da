<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AsyncCreators implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payload;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($package)
    {
        $this->payload = $package;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this->payload->type) {
            case 'product.created':
/*
                $this->payload->data->object->metadata['hotel_id']
                $this->payload->data->object->metadata['country_id']
                $this->payload->data->object->id
*/
                break;
            case 'price.created':
                break;
            case 'customer.created':
            case 'customer.updated':
                break;
        }
    }
}
