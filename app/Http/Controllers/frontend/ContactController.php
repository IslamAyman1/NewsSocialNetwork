<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    public function index(){
        return view('frontend.contact');
    }


    public function store(ContactRequest $request){
              $request->validated();
              $request->merge([
                   'ip_address' => $request->ip()
              ]);
              $contact = Contact::create($request->except('_token'));
              if(!$contact){
                  Session::flash('error', 'Contact us Failed');
                  return redirect()->back();
              }
              Session::flash('success', 'Your message has been sent');
              return redirect()->back();
    }
}
