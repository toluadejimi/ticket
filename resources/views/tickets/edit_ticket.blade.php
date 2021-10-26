@extends('layouts.app')
@section('title', 'Edit Ticket')
@section('content')
    <section id="main-home">
        <div class="main-home">
            <div class="main-img-area app">
                <div class="container">
                    <h1>Edit Ticket</h1>
                </div>
            </div>
        </div>
    </section>
    <section id="category-one">
        <div class="category-one">
            <div class="container contact">
                <div class="submit-area">
                   
                        <div class="col-md-12">
                            @if(count($errors->all()))
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Alert!</strong> {{ $error }}
                                    </div>
                                @endforeach
                            @endif


                            {{Form::open(['url'=>['/update/tickets',$ticket->id], 'class'=>'defaultForm','method' =>'post',  'files' => true])}}
                            <div class="small-border"></div>
                            <small>Edit Ticket</small>
                            <hr>

                            @if(Session::has('message'))
                                <div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Alert!</strong> {{Session::get('message')}}
                                </div>
                            @endif

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Customer Name</label>
                                    <input type="text" class="form-control" name="customer_name" value="{{$ticket->customer_name}}" required/>
                                </div>

                                <div class="form-group">
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Circuit ID</label>
                                        <input type="text" class="form-control" name="circuit_id" value="{{$ticket->circuit_id}}" required/>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Service Type</label>
                                        <select name="department" required class="form-control">
                                            @foreach($departments as $department)
                                                <option value="{{$department->id}}" {{($department->id) == $ticket->department_id ? 'selected' : ''}}>{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>                              
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Incident No</label>
                                    <input type="text" class="form-control" name="incident_number" value="{{$ticket->incident_number}}" required/>
                                </div>

                                <div class="form-group">
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Provider Ticket No</label>
                                        <input type="text" class="form-control" name="provider_ticket_number" value="{{$ticket->provider_ticket_number}}" required/>
                                    </div>
                                </div>

                                    <div class="form-group">
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Fault Time (GMT)</label>
                                            <input type="text" class="form-control"  id ="fault_time" name="fault_time" value="{{$ticket->fault_time}}" required/>
                                        </div>
                                    </div>                              
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Resolution Time (GMT)</label>
                                    <input type="datetime-local" class="form-control" id ="resolution_time" name="resolution_time" value="{{$ticket->resolution_time}}" required/>
                                </div>

                                <div class="form-group">
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Outage in Hours (H)</label>
                                        <input type="text" class="form-control" id ="outage_in_hours" name="outage_in_hours" value="{{$ticket->outage_in_hours}}" required/>
                                    </div>
                                </div>

                                    <div class="form-group">
                                        <div class="form-group col-md-4">
                                            @role('admin')
                                            <!-- Button trigger modal -->


<div class="submit-button" data-toggle="modal" data-target="#exampleModal" data-target="#exampleModal"  style=" margin-top:12px;">
 <button type="button" class="btn btn-default">Assign Ticket</button>
</div>
{{-- <button type="button" class="submit-button"  data-target="#exampleModal">
  Launch demo modal
</button> --}}

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Ticket  - {{ $ticket->customer_name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
                <div class="form-group col-md-4">
                    <div class="form-group">
                        <label class="control-label">Service Type</label>
                        <select name="department" required class="form-control">
                            @foreach($users as $user)
                                <option value="{{$user->id}}" {{($user->id) == $ticket->user_id ? 'selected' : ''}}>{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>                              
                </div>


      </div>
      <div class="modal-footer" >
        <div class="submit-button"  >
            <button type="button" class="btn btn-default">Assign</button>
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
           </div>
      </div>
    </div>
  </div>
</div>
                                           
                                            @endrole
                                        </div>
                                    </div>                              
                            </div>

                               

                
                               
                            </div>

                            {{-- <div class="form-row">
                                <div class="form-group col-md-6">                             
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Provider Ticket No</label>
                                        <input type="text" class="form-control" name="subject" value="{{$ticket->provider_ticket_number}}" required/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Fault Time (GMT)</label>
                                        <input type="text" class="form-control" name="subject" value="{{$ticket->fault_time}}" required/>
                                    </div>
                                </div>
                               
                            </div> --}}

                            <div class="form-group">
                                <label class="control-label">Reasons For Outage</label>
                                <textarea class="form-control" name="description"  required>{{$ticket->description}}</textarea>
                                <span class="help-block" id="message"></span>
                            </div>

                           

                           

                         

                            <div class="submit-button">
                                <button type="submit" class="btn btn-default">Update</button>
                            </div>

                            {{Form::close()}}

                        </div>
                        {{-- <div class="col-md-3 col-sm-12">
                            <div class="ticket-info">
                                <div class="title-sidebar">
                                    <h1>Ticket information</h1>
                                </div>
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td class="tno">#Token Number:</td>
                                        <td><span class="label-green">{{$ticket->token_no}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="tno">Submitted By:</td>
                                        <td><span>{{$ticket->submittedBy->name}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Service</td>
                                        <td class="tno">{{$ticket->departments->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>ticket status</td>
                                        <td><span class="ticket-status {{$ticket->status}}">{{$ticket->status}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Assigned ticket</td>
                                        @if($ticket->assigned_to  == null)
                                            <td class="tno">not assigned</td>
                                        @else
                                            <td class="tno">{{$ticket->users->name}}</td>
                                        @endif
                                    </tr>
                                    @role('admin')
                                    <tr>
                                        <td class="no-border">
                                            <span class="new-tk ticker">
                                                <a href="javascript:;" data-toggle="modal" data-target="#assign-ticket">
                                                    assign ticket
                                                </a>

                                            </span>
                                        </td>
                                        <td class="no-border">
                                            <span class="update-tk ticker">
                                                <a href="javascript:;" data-toggle="modal" data-target="#status-modal"> update status</a>
                                            </span>
                                        </td>
                                    </tr>
                                    @endrole

                                    </tbody>
                                </table>
                            </div> --}}
                            <!--ticket-files-->
                            {{-- <div class="ticket-files">
                                <div class="title-sidebar">
                                    <h1>Files</h1>
                                </div>
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>name</td>
                                        <td>uploaded by</td>
                                    </tr>

                                    @foreach($files as $file)
                                        <tr>
                                            <td>
                                                <a href="{{url('download')}}/{{$file->name}}" class="file-up">{{$file->name}}</a>
                                            </td>
                                            <td>{{$file->users->name}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div> --}}

                        </div>
                </div>
            </div>
        </div>
    </section>




    <script>
  
    function startTimer(display) {
      setInterval(function () {
        console.log("running");
         var fault_time =  document.getElementById("fault_time").value;
       var resolution_time =  document.getElementById("resolution_time").value;
           console.log(`mmmm ${resolution_time}`);
        var startTime = new Date(fault_time);
          if(resolution_time.length > 0){
        endTime = new Date(resolution_time);
        

    console.log(`miracele ${endTime}`);
    var diff = endTime - startTime; 
    var hours   = Math.floor(diff / 3.6e6);
    var minutes = Math.floor((diff % 3.6e6) / 6e4);
    var seconds = Math.floor((diff % 6e4) / 1000);
    console.log(diff)
      display.value = hours + ":" +minutes + ":" + seconds;
    
    
    }
           
      },1000)
       
    }

    window.onload = function () {
 
 var outage_in_hours = document.getElementById('outage_in_hours');
        startTimer(outage_in_hours);  
  

    };


 </script>
@stop


