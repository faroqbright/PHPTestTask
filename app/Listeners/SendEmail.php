<?php

namespace App\Listeners;

use App\Event\CapsuleEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CapsuleEvent  $event
     * @return void
     */
    public function handle(CapsuleEvent $event)
    {
        $syncJsonLog = array('cron start time' => Carbon::now());
        Log::info(json_encode($syncJsonLog));
        
        $to_email = "farooqbright@gmail.com";
        $data = array('name' => "Successfully");
        Mail::send('email', $data, function($message) use ($to_email) {
        $message->to($to_email)
        ->subject('Cron Job Mail');
        $message->from("farooqbright@gmail.com",'Cron Job Mail');
        });

    }
}
