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
                                    </div>

                                    <div class="col-sm-6 col-md-4">
                                            <h4><b>Service Type</h4></b>
                                            <h5>{{$ticket->department_id}}</h5>
                                        </br>
                                            <h4><b>Incedent No</h4></b>
                                            <h6>{{$ticket->incident_number}}</h6>
                                        </div>

                                    <div class="col-sm-6 col-md-4">
                                        <h4><b>Provider Ticket No</h4></b>
                                        <h5>{{$ticket->provider_ticket_number}}</h5>
                                    </br>
                                        <h4><b>Fault Time</h4></b>
                                        <h6>{{$ticket->fault_time}}</h6>
                                    </div>
                                </div>
                            
                            
                            </div>   
                                     


                            <div class="jumbotron">
                                    <h4><b>Reasons For Outage</h4></b>
                                    <h5>{{$ticket->description}}</h5>
                            </div>


                            <div class="jumbotron">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Resolution Time (GMT)</label>
                                        <input type="text" class="form-control" name="resolution_time" value="{{$ticket->resolution_time}}" required/>
                                    </div>
                               
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Outage in Hours (H)</label>
                                            <input type="text" class="form-control" name="outage_in_hours" value="{{$ticket->outage_in_hours}}" required/>
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
@stop

