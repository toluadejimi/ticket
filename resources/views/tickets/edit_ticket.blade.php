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
                            
                        








                            <div class="jumbotron">
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                            <h4><b>Customer Name</h4></b>
                                            <h5>{{$ticket->customer_name}}</h5>
                                        </br>
                                            <h4><b>Circuit ID</h4></b>
                                            <h6>{{$ticket->circuit_id}}</h6>
                                        </br>
                                            <h4><b>Assigned To</h4></b>
                                            <h6>{{$ticket->assigned_to}}</h6>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Fault Time (GMT)</label>
                                            <input type="text" class="form-control"  id ="fault_time" name="fault_time" value="{{$ticket->fault_time}}" required/>
                                    <div class="col-sm-6 col-md-4">
                                            <h4><b>Service Type</h4></b>
                                            <h5>{{$ticket->department_id}}</h5>
                                        </br>
                                            <h4><b>Incedent No</h4></b>
                                            <h6>{{$ticket->incident_number}}</h6>
                                        
                                        </br>
                                        <h4><b>Created At</h4></b>
                                        <h6>{{$ticket->created_at}}</h6>
                                        </div>
                                        

                                    <div class="col-sm-6 col-md-4">
                                        <h4><b>Provider Ticket No</h4></b>
                                        <h5>{{$ticket->provider_ticket_number}}</h5>
                                    </br>
                                        <h4><b>Fault Time</h4></b>
                                        <div id="f_time" <h6>{{$ticket->fault_time}}</h6> </div>
                                    </br>
                                         <h4><b><label for="">Ticket status</label> <span class="ticket-status {{$ticket->status}}">{{$ticket->status}}</span></h4></b>
                                            <select name="status"  value={{$ticket->status}} class="form-control">
                                                    <option>open</option>
                                                    <option>closed</option>
                                        </select> 


                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Resolution Time (GMT)</label>
                                    <input type="datetime-local" class="form-control" id ="resolution_time" name="resolution_time" value="{{$ticket->resolution_time}}" required/>
                                </div>
                            
                            
                            </div>   
                                    


                            <div class="jumbotron">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Resolution Time in Hours (H)</label>
                                        <input type="text" class="form-control" id ="outage_in_hours" name="outage_in_hours" value="{{$ticket->outage_in_hours}}" required/>
                                    </div>
                               
                                        <div class="form-group col-md-4">
                                            <label id="outage_in_hours" class="control-label">Outage in Hours (H)</label> 

                                            <input type="text" class="form-control" name="outage_in_hours" value="{{$outage_in_hours}}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Reassign to Staff</label> 
                                            <select name="assigned_to" class="form-control">
                                            @foreach($staffs as $staff)
                                                <option value="{{$staff->name}}">{{$staff->name}}</option>
                                            @endforeach
                                            </select>
                                        </div> 


                                </div> 
                            
                            </div>
                        <div class="jumbotron">
                             <div class="form-group">
                                <label class="control-label">Reasons for Outage</label>
                                <textarea class="form-control" name="description">{{ old('description')}} {{ $ticket->description }} 
                                </textarea>
                                <span class="help-block" id="message"></span>
                            </div>
                         </div>
                                     
{{--  
                                    <div class="form-group">
                                        <div class="form-group col-md-4">
                                            @role('admin')
                                           
                                           
                                            @endrole
                                        </div>
                                    </div>                                --}}
                         

                               

            

                           

                           

                           

                         

                            <div class="submit-button">
                                <button type="submit" class="btn btn-default">Update</button>
                            </div>

                            {{Form::close()}}


                            

                            <div class="jumbotron">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6">
                                            <div class = "container">
                                                    <label> Reasons for Outage </label>
                                                    @foreach ($updated_tickets as $object)
                                                    <h6>{{$object->description}}</h6>
                                                    @endforeach
                                            </div>
                                        </div>

                                    

                                        <div class="col-sm-6 col-md-3">
                                            
                                                <label> Updated By </label>
                                                    @foreach ($updated_tickets as $object)
                                                    <h6>{{$object->updated_by}}</h6>
                                                    @endforeach
                                               
                                        </div>

                                        
                                        <div class="col-sm-6 col-md-3">
                                          <label> Time Updated </label>
                                            @foreach ($updated_tickets as $object)
                                            <h6>{{$object->updated_at}}</h6>
                                            @endforeach
                                        </div>
                                         
                                    </div>


                            </div>

                        {{--  </div>
                            <div class="table-section">
                                <div class="table-responsive">
                                    <table class="table table-lead user-table">
                                        <thead>
                                            <tr>
                                                <th class="heading">Reasons for Outage</th>
                                                <th class="heading">Updated By</th>
                                                <th class="heading">Time Updated</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($updated_tickets as $object)
                                                    <tr>
                                                        <td>{{$object->description}}</td>
                                                        <td>{{$object->updated_by}}</td>
                                                        <td>{{$object->updated_at}}</td>
                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            
                            </div>

                        </div>  --}}
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
<<<<<<< HEAD




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
=======
 <script>
                                                function myFunction() {
                                                    var r_time = document.getElementById("r_time").value;
                                                    var f_time = document.getElementById("f_time").value;
                                                    var outage_in_hours = r_time - f_time;
                                                    
                                                    document.getElementById("outage_in_hours").innerHTML = outage_in_hours;
                                                    
                                                }
                                            </script>
   
>>>>>>> 587677f4db067b776e67d68c64efc6a07fc6444f
@stop

  