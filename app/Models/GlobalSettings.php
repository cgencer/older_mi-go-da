<?php

namespace App\Models;

use Collection, Jenssegers\Model\Model;
use Illuminate\Support\Facades\App;

class GlobalSettings extends Model
{
    protected $settings;
    protected $keyValuePair;

    public function __construct($settings=[])
    {
        $this->settings = $settings;
        foreach ($settings as $setting){
            $this->keyValuePair[$setting->key] = $setting->value;
        }
		$this->keyValuePair['console'] = (!App::runningInConsole()) ? true : false;
        $this->keyValuePair['cronjob'] = (boolean) env('CRON_MODE', false);
        $this->keyValuePair['server'] = isset($_ENV["APACHE_RUN_DIR"]) ? true : false;
        $this->keyValuePair['environment'] = (
            (App::environment('local') || App::environment('local-cg') ) ? 'LOCAL' :
                (App::environment('beta') ? 'BETA' :
                    (App::environment('beta2') ? 'BETA2' :
    				    (App::environment('production') ? 'PROD' : 'LOCAL') ) ) );	// if its not any, use LOCAL
    }

    public function has(string $key){
    	return (in_array($key, array_keys($this->keyValuePair))) ? true : false;
    }

    public function contains(string $key){ /* check value exists */ }

    public function get(string $key){
        return $this->keyValuePair[$key];
    }

    public function set(string $key, $val){
        $this->keyValuePair[$key] = $val;
        $this->settings[$key] = $val;
    }

    public function getEnv(){
        return $this->keyValuePair['environment'];
    }

}
