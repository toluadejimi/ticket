@extends('layouts.app')
@section('title', 'Report')

@section('content')

{{-- start --}}
 <section id="category-one">
        <div class="category-one">
             {{-- <form action="{{url('/report')}}" method="post" > --}}
                   {{Form::open(['url'=>'/report', 'class'=>'defaultForm','method' =>'post',  'files' => true])}}


            <div class="container contact">
              
                <div class="row">
                 
               
                             <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label class="control-label">Start Date</label>
                                                <input type="date" class="form-control" name="start_date" value="" required/>
                                            </div>

                                            <div class="form-group">
                                                <div class="form-group col-md-4">
                                                    <label class="control-label">End Date</label>
                                                    <input type="date" class="form-control" name="end_date" value="" required/>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label class="control-label">Assignee</label>
                                                                    <select name="user_name" class="form-control">
                                                                            @foreach($users as $user)
                                                                                <option value="{{$user->name}}">{{$user->name }}</option>
                                                                            @endforeach

                                                                    </select>
                                            </div>

                                            
                                        </div>
                                       

                                                     

                            </div> 
                             <div class="row">
                                  <div class="form-row">
                                      <div class="form-group col-md-4">

                                                    <div class="form-check">
                                                            <input class="form-check-input"  name="isOpen" type="checkbox"  id="defaultCheck1">
                                                            <label class="form-check-label" for="defaultCheck1">
                                                                Open
                                                            </label>
                                                        </div>
                                      </div>
                                      
                                            <div class="form-group col-md-4">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true">
                                                </i>
                                            </button> <label class="form-check-label" for="defaultCheck1">          Apply</label>
                                            </div>
                                  </div>
                                  </div>
                             </div>

             {{-- </form> --}}
               {{Form::close()}}
                                           
                                            
 <section id="category-one">
            <div class="category-one">
                <div class="container">
                    <div class="row">
                        <div class="col-md-24 col-sm-24">
                            <div class="table-section">
                                <h3 class="title clearfix">Tickets <span>List</span></h3>
                               

                                
                                <div class="table-responsive">
                                    <table class="table table-lead ticket-table">
                                        <thead>
                                        <tr>
                                            <th class="heading">Customer Name</th>
                                            <th class="heading">Circuit ID</th>
                                            <th class="heading">Service Type</th>
                                            <th class="heading">Incident No</th>
                                            <th class="heading">Provider Ticket No</th>
                                            <th class="heading">Fault Time (GMT)</th>
                                            <th class="heading">Resoultion Time (GMT)</th>
                                            <th class="heading">Status</th>
                                            <th class="heading">Date</th>
                                            @role('staff')
                                            <th class="heading">Submitted By</th>
                                            @endrole
                                            <th class="heading">action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($tickets as $ticket)
                                            @if($ticket->user_id == Auth::id() || $ticket->assigned_to == Auth::id())
                                                <tr id="{{$ticket->id}}">
                                                    <td>{{$ticket->customer_name}}</td>
                                                    <td>{{$ticket->circuit_id}}</td>
                                                    <td>{{$ticket->departments->name}}</td>
                                                    <td>{{$ticket->incident_number}}</td>
                                                    <td>{{$ticket->provider_ticket_number}}</td>
                                                    <td>{{$ticket->fault_time}}</td>
                                                    <td>{{$ticket->resolution_time}}</td>
                                                    @role('staff')
                                                    @if($ticket->user_id == Auth::id())
                                                        <td>me</td>
                                                    @else
                                                        <td>{{$ticket->submittedBy->name}}</td>
                                                    @endif
                                                    @endrole

                                                    <td>
                                                    <span class="ticket-status {{$ticket->status}}">
                                                        {{$ticket->status}}
                                                    </span>
                                                    </td>

                                                    <td>{{$ticket->created_at->format('d-m-Y')}}</td>
                                                    <td>
                                                        @if(Auth::user()->hasRole('client'))
                                                            @if($settings->client_can_edit == 'yes')
                                                                <a href="{{url('edit/tickets')}}/{{$ticket->id}}" class="eye" data-id="{{$ticket->id}}">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            @endif
                                                        @endif
                                                        @if(Auth::user()->hasRole('staff'))
                                                            @if($settings->staff_can_edit == 'yes')
                                                                <a href="{{url('edit/tickets')}}/{{$ticket->id}}" class="eye" data-id="{{$ticket->id}}">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            @endif
                                                        @endif


                                                        <a href="javascript:;" class="eye delete-btn" data-id="{{$ticket->id}}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                {{ $tickets->links() }}
                            </div>
                        </div>
                        
                                <div class="ticket-info">
                                    {{--  --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

                                            
                                       

                                      

                        </div>
                    </div>
 </section>
{{-- end --}}



@stop

@section('script')
     <script>
        $(document).ready(function () {
            $('.navbar-default .navbar-nav li').removeClass('active');
            $('.navbar-default .navbar-nav li.ticket').addClass('active');
            $(".delete-btn").on('click', function () {
                var id = $(this).attr('data-id');
                swal({
                            title: "Are you sure?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes, delete it!",
                            cancelButtonText: "No, cancel!",
                            closeOnConfirm: false,
                            closeOnCancel: true
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                $.ajax({
                                    type: 'POST',
                                    url: '{{url('/delete/tickets')}}'+"/"+id,
                                    data:{
                                        id:id,
                                        '_token': '{{csrf_token()}}'
                                    },
                                    success: function (data) {
                                        $('.ticket-table tr#'+id+'').hide();
                                        swal("Deleted!", "Record has been deleted.", "success");

                                    }
                                })
                            } else {
                                swal("Cancelled", "Record is safe :)", "error");
                            }
                        });
            });
        });
    </script>
@stop