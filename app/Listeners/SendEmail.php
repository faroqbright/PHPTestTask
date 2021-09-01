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

        Mail::send('email', [], function($message) {
            // $message->to($event->email);
            $message->to("faroqbright@gmail.com");
            $message->subject('Database Updated');
        });
    }
}
