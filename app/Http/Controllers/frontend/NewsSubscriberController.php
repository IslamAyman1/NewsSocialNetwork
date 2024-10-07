<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Mail\Frontend\NewSubscriberMail;
use App\Models\NewSuscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Flasher\Prime\FlasherInterface;

class NewsSubscriberController extends Controller
{

    public function store(Request $request)
    {
             $request->validate([
                'email' => ['required', 'email' ,'unique:new_suscribers']
            ]);


           $newSubscriber = NewSuscriber::create([
                'email' => $request->email,
            ]);

           if (!$newSubscriber) {
               Session::flash('error', 'There was an error sending your message.');
           }
           Mail::to($request->email)->send(new NewSubscriberMail());
           Session::flash('success', 'You have successfully subscribed to our newsletter.');
           return redirect()->back();
    }
}
