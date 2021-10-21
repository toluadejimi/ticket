<?php

namespace App\Http\Controllers;




if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

use App\Notifications\NewTicket;
use Illuminate\Support\Facades\DB;
use App\Notifications\TicketReply;
use App\Notifications\TicketStatus;
use App\Controllers\UsersController;
use App\Replies;
use App\Settings;
use App\Tickets;
use App\Departments;
use App\User;
use App\Customer;
use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Files;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller;
use Validator;


class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        // dd("ticket");
        if(Auth::user()->hasRole('admin')){
            return redirect::to('admin/tickets');
        }else{
            $tickets = Tickets::paginate(10);
            $open = Tickets::where(['assigned_to' => Auth::id(), 'status'=> 'open'])->orWhere(['user_id'=> Auth::id(), 'status'=> 'open'])->count();
            $replied = Tickets::where(['assigned_to' => Auth::id(), 'status'=> 'replied'])->orWhere(['user_id'=> Auth::id(), 'status'=> 'replied'])->count();
            $closed = Tickets::where(['assigned_to' => Auth::id(), 'status'=> 'closed'])->orWhere(['user_id'=> Auth::id(), 'status'=> 'closed'])->count();
            $pending = Tickets::where(['assigned_to' => Auth::id(), 'status'=> 'pending'])->orWhere(['user_id'=> Auth::id(), 'status'=> 'pending'])->count();
            $departments = Departments::all();
            $tickets_depart = Tickets::where('assigned_to', Auth::id())->orWhere('user_id', Auth::id())->get();

            return view('tickets.index', compact('tickets', 'open','replied', 'closed', 'pending', 'departments', 'tickets_depart'));

        }

    }

    public function create(){
        $departments = Departments::all();
        $staffs = Staff::all();
        $customers = Customer::all();
        return view('tickets.new_ticket', compact('departments', 'customers', 'staffs'));

       
    }

    public function store(Request $request){

        
        $customers = Customer::all();
        // dd($customers);
        $selected_customer_name = array();
        
        $index = 0;
        foreach ($request -> customer_name as $value) {

            $selected_customer_name[$index] = $customers[$index]-> customer_name;
            // array_push($selected_customer_name, $customers[$value]-> customer_name);
        $index++;
        }





        $ticket = new Tickets();
        $ticket->customer_name = implode(",",$selected_customer_name);
        $ticket->incident_number = $request->incident_number;
        $ticket->assigned_to = $request ->assigned_to;
        $ticket->provider_ticket_number = $request->provider_ticket_number;
        $ticket->fault_time = $request->fault_time;
        // $ticket->outage_in_hours = $request->outage_in_hours;
        // $ticket->resolution_time = $request->resolution_time;
        $ticket->circuit_id = $request->circuit_id;
        $ticket->department_id = $request->department_id;
        $ticket->user_id = Auth::id();
        $ticket->token_no = rand(1000, 10000);
        $ticket->description = $request->description;
        $ticket->status = 'open';
        $ticket->save();

        if (Input::hasFile('file')) {
            $files = new Files();
            $files->name = $request->file->getClientOriginalName();
            $files->user_id = (Auth::user()) ? Auth::id() : null;
            $files->ticket_id =  $ticket->id;
            $files->reply_id =  0;
            $files->save();
            Storage::putFileAs('', $request->file, $request->file->getClientOriginalName());
        }

        $title = $request->subject;
        $ticket_id = $ticket->id;
        $user_name = Auth::user()->name;

        $users = User::all();
        foreach ($users as $user){
            if($user->hasRole('admin')){
                $user->notify(new NewTicket($title, $user_name, $ticket_id));
            }
        }
        $settings = Settings::all()->first();
        if($settings->ticket_email == 'yes'){
            $department = Departments::find($request->department_id);
            Mail::send('mails.thanks',['ticket'=>$request, 'department' => $department], function ($message) use ($settings){
                $message->from('no-reply@gmail.com', 'Ticket Plus');
                $message->subject('New Ticket Created');
                $message->to($settings->admin_email);
            });
        }
        return redirect::to('tickets');
    }


    public function editTickets($id){

        
        $user = User::find(Auth::id());
        $departments = Departments::all();
        if($user->hasRole('admin', )){
            $ticket = Tickets::find($id);
            $users = User::all();
            if(count($ticket)){
                return view('tickets.edit_ticket', compact('ticket', 'users','departments'));
            }else

            // dd("me");
                return redirect::to('tickets');


       

        }else{
            $ticket = Tickets::where(['assigned_to'=> Auth::id(), 'id' => $id])->orWhere(['user_id'=> Auth::id(), 'id' => $id])->first();
            if(count($ticket)){

                
                return view('tickets.edit_ticket', compact('ticket',  'departments'));
            }else

            // 
                return redirect::to('tickets');
        }


        
        
    }

    public function ticketDetail($id){
        $user = User::find(Auth::id());
        $staff = [];
        $users_list = User::all();
        foreach ($users_list as $item){
            if($item->hasRole('staff')){
                $staff[] = $item;
            }
        }
        if($user->hasRole('admin')){
            $ticket = Tickets::find($id);
            if(count($ticket)){
                $replies = Replies::where('ticket_id', $ticket->id)->get();
                $files = Files::where('ticket_id', $ticket->id)->get();
                return view('tickets.details', compact('ticket', 'replies', 'files', 'staff'));
            }else
                return redirect::to('tickets');

        }else{
            $ticket = Tickets::where(['assigned_to'=> Auth::id(), 'id' => $id])->orWhere(['user_id'=> Auth::id(), 'id' => $id])->first();
            if(count($ticket)){
                $replies = Replies::where('ticket_id', $ticket->id)->get();
                $files = Files::where('ticket_id', $ticket->id)->get();
                return view('tickets.details', compact('ticket', 'replies', 'files', 'staff'));
            }else
                return redirect::to('tickets');
        }
    }

    public function updateTickets(Request $request, $id){

        // $this->validate($request, [
        //     'department' => 'required',
        //     'subject' => 'required|max:300',
        //     'description' => 'required|max:10000'
        // ]);

        $ticket = new Tickets();
        $ticket->customer_name = $request->customer_name;
        $ticket->incident_number = $request->incident_number;
        $ticket->provider_ticket_number = $request->provider_ticket_number;
        $ticket->fault_time = $request->fault_time;
        $ticket->outage_in_hours = $request->outage_in_hours;
        $ticket->resolution_time = $request->resolution_time;
        $ticket->circuit_id = $request->circuit_id;
        $ticket->department_id = $request->department_id;
        $ticket->user_id = Auth::id();
        $ticket->token_no = rand(1000, 10000);
        $ticket->description = $request->description;
        $ticket->status = 'open';
        $ticket->save();
        return redirect()->back()->withMessage('ticket has been updated successfully');
    }

    public function deleteTickets($id){
        $ticket = Tickets::find($id);
        $files = Files::where('ticket_id', $ticket->id)->get();
        foreach ($files as $file){
            Storage::delete($file->name);
        }
        Files::where('ticket_id', $ticket->id)->delete();
        Replies::where('ticket_id', $ticket->id)->delete();
        Tickets::find($id)->delete();
        return 'success';
    }


    public function adminTickets(){
        $tickets = Tickets::paginate(15);
        $open = Tickets::where('status', 'open')->count();
        $replied = Tickets::where('status', 'replied')->count();
        $closed = Tickets::where('status', 'closed')->count();
        $pending = Tickets::where('status', 'pending')->count();
        $departments = Departments::all();
        $tickets_depart = Tickets::all();
        return view('admin.tickets.index', compact('tickets', 'open','replied', 'closed', 'pending', 'departments', 'tickets_depart'));
    }

    public function addReply(Request $request){

        $reply = new Replies();
        $reply->reply = $request->reply;
        $reply->ticket_id = $request->ticket_id;
        $reply->user_id = Auth::id();
        $reply->save();
        $ticket = Tickets::find($request->ticket_id);

        $title = $ticket->subject;
        $ticket_id =$request->ticket_id;
        $reply_user = Auth::user()->name;
        if(Auth::user()->hasRole('admin')){
            $user = User::find($ticket->user_id);
            $user->notify(new TicketReply($title, $reply_user, $ticket_id));
            if(!empty($ticket->assigned_to)){
                $user2 = User::find($ticket->assigned_to);
                $user2->notify(new TicketReply($title, $reply_user, $ticket_id));
            }

        }
        elseif(Auth::user()->hasRole('client')){
            $users = User::all();
            foreach ($users as $user){
                if($user->hasRole('admin')){
                    $user->notify(new TicketReply($title, $reply_user, $ticket_id));
                }
            }

            if(!empty($ticket->assigned_to)){
                $user2 = User::find($ticket->assigned_to);
                $user2->notify(new TicketReply($title, $reply_user, $ticket_id));
            }
        }
        elseif(Auth::user()->hasRole('staff')){
            $users = User::all();
            foreach ($users as $user){
                if($user->hasRole('admin')){
                    $user->notify(new TicketReply($title, $reply_user, $ticket_id));
                }
            }
            $user2 = User::find($ticket->user_id);
            $user2->notify(new TicketReply($title, $reply_user, $ticket_id));
        }




        $user_image = '';
        if(Auth::user()->avatar ==  null){
            $user_image = '<img src="'.asset('uploads/avatar.png').'" alt="avatar" class="img-circle">';
        }else{
            $user_image = '<img src="'.asset('uploads').'/'.Auth::user()->avatar.'" alt="avatar" class="img-circle">';
        }

        $output = '';

        if (Input::hasFile('file'))
        {
            $file = new Files();
            $file->name = Input::file('file')->getClientOriginalName();
            $file->user_id = Auth::id();
            $file->ticket_id =  $request->ticket_id;
            $file->reply_id =  $reply->id;
            $file->save();
            Storage::putFileAs('', $request->file, $request->file->getClientOriginalName());

            $output = '
                        <div class="ticket-detail-box">
                            <div class="outer-white"  id="'.$reply->id.'">
                                <h3 class="title">
                                '.$user_image.'
                                '.Auth::user()->name.' |
                                <span class="text-muted date">Date: '. $reply->created_at->format('d-m-Y').'</span>
                                 <span class="text-muted time">
                                 @ '.$reply->created_at->format('H:i').'
                                </span>

                                <a href="javascript:;"  class="basic-button delete-btn red pull-right" data-id="'.$reply->id.'">
                                 <i class="fa fa-trash"></i>
                                  </a>


                                </h3>
                                <p class="details">
                                    '.$request->reply.'
                                </p>
                                <p class="file_link">
                                    Attached File:
                                        <a href="'.url('download').'/'.$file->name.'">
                                            <i class="fa fa-paperclip"></i> '.$file->name.'
                                        </a>
                                </p>
                            </div>
                        </div>';
            return $output;
        }else{

            $output = '
                        <div class="ticket-detail-box">
                            <div class="outer-white" id="'.$reply->id.'">
                                <h3 class="title">
                                 '.$user_image.'
                                '.Auth::user()->name.' |
                                <span class="text-muted date">Date: '. $reply->created_at->format('d-m-Y').'</span>
                                 <span class="text-muted time">
                                 @ '.$reply->created_at->format('H:i').'
                                </span>
                                 <a href="javascript:;"  class="basic-button delete-btn red pull-right" data-id="'.$reply->id.'">
                                 <i class="fa fa-trash"></i>
                                  </a>
                                </h3>
                                <p class="details">
                                 '.$request->reply.'
                                  </p>
                            </div>
                        </div>';
            return $output;
        }
    }

    public function deleteReplies($id) {
        $files = Files::where(['reply_id' => $id, 'user_id' => Auth::id()])->get();
        foreach ($files as $file){
            Storage::delete($file->name);
        }
        Files::where(['reply_id' => $id, 'user_id' => Auth::id()])->delete();
        Replies::where(['id' => $id, 'user_id' => Auth::id()])->delete();
        return 'success';
    }


    public function updateStatus(Request $request, $id){
        $tickets = Tickets::find($id);
        $tickets->status = $request->status ;
        $tickets->save();

        $title = $tickets->subject;
        $ticket_id = $id;
        $status = $request->status;
        $user = User::find($tickets->user_id);
        $user->notify(new TicketStatus($title, $status, $ticket_id));
        return redirect()->back();
    }


    public function download($file_name){

        $path = storage_path('app/').$file_name;
        return response()->download($path);
    }

    public function assignTicket(Request $request, $id){
        $ticket = Tickets::find($id);
        $ticket->assigned_to = $request->assign;
        $ticket->save();
        return redirect()->back();

    }



}
