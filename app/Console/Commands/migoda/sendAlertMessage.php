<?php

namespace App\Console\Commands\migoda;

use Illuminate\Console\Command, Auth;
use App\Models\AlertMessage;

class sendAlertMessage extends Command
{
    protected $signature = 'miogda:alert:message {message} {--q=}';

    protected $description = 'Send alert message.';

    public function handle()
    {
        $uid = (null !== $this->option('q')) ? $this->option('q') : Auth::guard('customer')->user()->id;
        if($uid){
            $message = AlertMessage::create([
                'user_id' => $uid,
                'message' => $this->argument('message')
            ]);

            event(new \App\Events\AlertMessageWasReceived($message, $uid));
            $this->warn('message sent.');
        }else{
            $this->warn('message couldnt be sent.');
        }
    }
}
