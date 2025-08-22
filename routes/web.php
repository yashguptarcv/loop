<?php

use Illuminate\Support\Facades\Route;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
     $details = [
            'name' => 'John Doe',
        ];

        // Push mail to queue instead of sending immediately
        Mail::to('yash.gupta@rcvtechnologies.com')->queue(new WelcomeMail($details));

        return "Email has been queued!";
});

