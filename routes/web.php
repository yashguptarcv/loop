<?php

use Illuminate\Support\Facades\Route;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;


Route::get('/test_mail', function () {
    
    $details = [
        'name' => 'John Doe',
    ];
    Mail::to('yash.gupta@rcvtechnologies.com')->queue(new WelcomeMail($details));
        // Push mail to queue instead of sending immediately

        // return "Email has been queued!";
});

