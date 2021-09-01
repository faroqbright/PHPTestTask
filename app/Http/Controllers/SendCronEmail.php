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
    	Mail::send('email', [], function($message) {
            $message->to('bilal.sheikh@appcrates.com');
            $message->subject('Database Updated');
        });

    }
}
