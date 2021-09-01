<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event\CapsuleEvent;
use Mail;

class SendCronEmail extends Controller
{
    //
    public function index()
    {
        $to_email = "farooqbright@gmail.com";
        $data = array('name' => "Successfully");
        Mail::send('email', $data, function($message) use ($to_email) {
        $message->to($to_email)
        ->subject('Cron Job Mail');
        $message->from("farooqbright@gmail.com",'Cron Job Mail');
        });

    }
}
