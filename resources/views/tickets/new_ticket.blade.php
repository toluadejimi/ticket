@extends('layouts.app')
@section('title', 'New Ticket')
@section('content')

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
                            


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="">Customer Name</label>
                                  <input type="text" name="customer_name" class="form-control">
                                </div>
                                  <div class="form-group col-md-6">
                                     <label for="">Circiut ID</label>
                                    <input type="text" name="circuit_id" class="form-control">
                                  </div>
                              </div>

                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="">Service Type</label>
                                  <select name="department_id" class="form-control">
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach

                                </select>
                                </div>
                                  <div class="form-group col-md-6">
                                     <label for="">Incident No</label>
                                    <input type="number" name="incident_number" class="form-control">
                                  </div>
                              </div>

                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="">Provider Ticket No</label>
                                  <input type="number" name="provider_ticket_number" class="form-control">
                                </div>
                                  <div class="form-group col-md-6">
                                     <label for="">Fault Time (GMT)</label>
                                    <input type="datetime-local" name="fault_time" class="form-control">
                                  </div>
                              </div>

                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="">Resolution Time (GMT)</label>
                                  <input type="datetime-local" name="resolution_time" class="form-control">
                                </div>
                                  <div class="form-group col-md-6">
                                     <label for="">Outage in Hours (H)</label>
                                    <input type="text" name="outage_in_hours" class="form-control">
                                  </div>
                              </div>


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
@stop
