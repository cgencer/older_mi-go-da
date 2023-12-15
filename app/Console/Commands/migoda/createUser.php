<?php

namespace App\Console\Commands\migoda;

use Illuminate\Console\Command;
use App, Config, Hash;

class createUser extends Command
{
    protected $signature = 'migoda:create:user';
    protected $description = 'Create a new user';

    public function handle()
    {
        // Retrieve attributes
        $attributes = config('commands.user_attributes');

        // Retrieve sensitive fields
        $sensitive_attributes = config('commands.user_attributes_sensitive');

        // Ask questions and prepare data
        foreach ($attributes as $attribute => $question) {
            if (is_null($attribute) || $attribute === 0) {
                $attribute = $question;
            }

            // Check if sensitive field
            if (in_array($attribute, $sensitive_attributes)) {
                $attributes[$attribute] = Hash::make($this->secret($question));
                continue;
            }

            $attributes[$attribute] = $this->ask($question);
        }

        // Create new user
        try {
            $user = App::make(config('commands.user'));
            $user::create($attributes);
            $this->info('User created');
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}