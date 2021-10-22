@extends('layouts.app')
@section('title', 'New Ticket')
@section('content')


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">   
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

    



    <section id="main-home">
        <div class="main-home">
            <div class="main-img-area app">
                <div class="container">
                    <h1>Add New Ticket</h1>
                </div>
            </div>
        </div>
    </section>

    <section id="category-one">
        <div class="category-one">
            <div class="container contact">
                <div class="submit-area">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            {{Form::open(['url'=>'/tickets', 'class'=>'defaultForm','method' =>'post',  'files' => true])}}
                            <div class="small-border"></div>
                            <small>SUBMIT YOUR</small>
                            <h1>TICKET</h1>

                            <hr>

                            @if(count($errors->all()))
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Alert!</strong> {{ $error }}
                                    </div>
                                @endforeach
                            @endif
                            


                        
                             <div class="form-group col-md-12">
                                <label for="">Customer Name</label>
                                <select id="multiple-checkboxes-filter" multiple="multiple" name="customer_name[]" class="form-control">
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->customer_name}}">{{$customer->customer_name}}</option>
                                    @endforeach
                                  </select> 

                             </div> 

                          <div class="form-row">
                                <div class="form-group col-md-12">
                                     <label for="">Circuit ID</label>
                                    <input type="text" name="circuit_id" class="form-control">
                                  </div>
                            

                          </div>

   
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="">Service Type</label>
                                  <select name="department_id" class="form-control">
                                    @foreach($departments as $department)
                                        <option value="{{$department->name}}">{{$department->name}}</option>
                                    @endforeach

                                </select>
                                </div>
                                  <div class="form-group col-md-6">
                                     <label for="">Incident No</label>
                                    <input type="number" name="incident_number" class="form-control">
                                  </div>
                              </div>

                              <div class="form-row">
                                <div class="form-group col-md-4">
                                  <label for="">Provider Ticket No</label>
                                  <input type="text" name="provider_ticket_number" class="form-control">
                                </div>
                                  <div class="form-group col-md-4">
                                     <label for="">Fault Time (GMT)</label>
                                    <input type="datetime-local" name="fault_time" class="form-control">
                                  </div>
                                
                                <div class="form-group col-md-4">
                                     <label for="">Assign to Staff</label>
                                  <select name="assigned_to" class="form-control">
                                    @foreach($staffs as $staff)
                                        <option value="{{$staff->name}}">{{$staff->name}}</option>
                                    @endforeach
                                  </select> 
                                  </div>



                              </div>

                              {{--  <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="">Resolution Time (GMT)</label>
                                  <input type="datetime-local" name="resolution_time" class="form-control">
                                </div>
                                  <div class="form-group col-md-6">
                                     <label for="">Outage in Hours (H)</label>
                                    <input type="text" name="outage_in_hours" class="form-control">
                                  </div>
                              </div>  --}}


                              <div class="form-group">
                                <label class="control-label">Reasons for Outage</label>
                                <textarea class="form-control" name="description" required>{{ old('description')}}</textarea>
                                <span class="help-block" id="message"></span>
                            </div>

                            

                            

                            <div class="submit-button">
                                <button type="submit" class="btn btn-default">SUBMIT</button>
                            </div>

                            {{Form::close()}}

                        </div>
                    </div>
                </div>
            </div>
        </div>




    </section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>		
<script>
$(document).ready(function () {
                $('#multiple-checkboxes').multiselect({
                    includeSelectAllOption: true
                });
                $('#multiple-checkboxes-filter').multiselect({
                    includeSelectAllOption: true,
                    enableCaseInsensitiveFiltering: true
                });
            });
</script>














@stop


