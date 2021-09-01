<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Capsule;
use App\Mission;
use App\Event\CapsuleEvent;

class CapsuleCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'capsule:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $URL='https://api.spacexdata.com/v3/capsules';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        $result=curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        curl_close ($ch);
        
        // return $result;
        $spacexdata = json_decode($result);

        for ($i=0; $i < count($spacexdata); $i++) { 
            
            $capsule = new Capsule();
            $capsule->capsule_id = $spacexdata[$i]->capsule_id;
            $capsule->capsule_serial = $spacexdata[$i]->capsule_serial;
            $capsule->capsule_id = $spacexdata[$i]->capsule_id;
            $capsule->status = $spacexdata[$i]->status;
            $capsule->original_launch = $spacexdata[$i]->original_launch;
            $capsule->original_launch_unix = $spacexdata[$i]->original_launch_unix;
            $capsule->landings = $spacexdata[$i]->landings;
            $capsule->type = $spacexdata[$i]->type;
            $capsule->details = $spacexdata[$i]->details;
            $capsule->reuse_count = $spacexdata[$i]->reuse_count;
            $capsule->save();
            
            $missions = $spacexdata[$i]->missions;
            if(!empty($missions)){
                for ($j=0; $j < count($missions); $j++) {
                    $mission = new Mission();
                    $mission->capsule_id = $capsule->id;
                    $mission->name = $missions[$j]->name;
                    $mission->flight = $missions[$j]->flight;
                    $mission->save();
                }
            }
        }
        event(new CapsuleEvent("Your data saved in database successfully"));
    }
}
