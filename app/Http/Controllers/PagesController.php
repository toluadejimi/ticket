<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Settings;
use App\Tickets;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PagesController extends Controller
{

    public function report(Request $request){

        $from = date($request->start_date);
        $to = date($request->end_date);
        // $tickets = Tickets::paginate(15);
      
        $users = User::all();
        $customers = Customer::all();

        if (!is_null($request->user_name)) {


            $tickets = Tickets::where('assigned_to', $request->user_name)->where("status", $request->status)->paginate(2)->appends(request()->query());

            return view(
                'pages.report',
                compact('tickets', 'users', 'customers')
            );
        } else if (!is_null($request->start_date) || !is_null($request->end_date)) {

            $tickets = Tickets::whereBetween('created_at', [$from, $to])->orWhere("status", "status", $request->status)->paginate(2)->appends(request()->query());
                // return redirect('pages.report')->with(compact('tickets', 'users', 'customers'));
            return view(
                'pages.report',
                compact('tickets', 'users', 'customers')
            );
        } elseif (!is_null($request->customer_name)) {


            $tickets = Tickets::where('customer_name', 'like', "%{$request->customer_name}%")->where("status", $request->status)->paginate(2)->appends(request()->query());

            return view(
                'pages.report',
                compact('tickets', 'users', 'customers')
            );
        } else {

            $tickets = Tickets::where("status", $request->status)->paginate(2)->appends(request()->query());

            return view(
                'pages.report',
                compact('tickets', 'users', 'customers'),
                
            );
        }
       

        
    }

    public function postReport(Request $request)
    {
        $users = User::all();
        $customers = Customer::all();

        $from = date($request->start_date);
        $to = date($request->end_date);


     
          
        

        if(!is_null($request->user_name)){
         

            $tickets = Tickets::where('assigned_to', $request->user_name)->where("status", $request->status )->paginate(15);
            
            return view(
                'pages.report',
                compact('tickets', 'users', 'customers')
            );
        

        }
         else if(!is_null($request->start_date) || !is_null($request->end_date)){

         $tickets = Tickets::whereBetween('created_at', [$from, $to])->orWhere("status","status", $request->status)->paginate(15);
           
            return view('pages.report',
                compact('tickets', 'users', 'customers')
            );
                }elseif(!is_null($request->customer_name)){
    

            $tickets = Tickets::where('customer_name', 'like', "%{$request->customer_name}%")->where("status", $request->status)->paginate(15);

            return view(
                'pages.report',
                compact('tickets', 'users', 'customers')
            );
                }else{
          
            $tickets = Tickets::where("status", $request->status)->paginate(15);

            return view(
                'pages.report',
                compact('tickets', 'users', 'customers')
            );
       }


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
