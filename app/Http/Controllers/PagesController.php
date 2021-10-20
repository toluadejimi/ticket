<?php

namespace App\Http\Controllers;

use App\Settings;
use App\Tickets;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{

    public function report(){

        $tickets = Tickets::paginate(15);
        $users = User::all();

        return view('pages.report', compact('tickets', 'users'));
    }

    public function postReport(Request $request)
    {
        dd($request->all());


            // return redirect::to('tickets');
        // return view('pages.report', compact('tickets', 'users'));
    }





    public function contact(){
        return view('pages.contact');
    }

    public function contactMail(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'description' => 'required|min:15|max:10000'
        ]);
        $settings = Settings::all()->first();
        Mail::send('mails.contact',['request'=>$request], function ($message) use ($settings){
            $message->from('no-reply@gmail.com', 'Ticket Plus New Contact');
            $message->subject('New Contact');
            $message->to($settings->admin_email);
        });
        return redirect()->back()->withMessage('Contact form submitted. We will get back to you soon.');
    }

}
