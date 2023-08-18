@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-3">Trips</div>
                        <div class="col-7"></div>
                        <a class="col-2 btn btn-small btn-primary text-light" data-toggle="modal" data-target="#ModalCreate">Start Trip</a>
                    </div>
                    <div class="card-body">

                        @if($errors)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        <!-- will be used to show any messages -->
                        @if (Session::has('message'))
                            <div class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif
                        <table class="table table-striped table-bordered" id="table">
                            <thead>
                            <tr>
                                <td>To</td>
                                <td>From</td>
                                <td>current status</td>
                                <td>Actions</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($trips as $key => $value)
                            <tr>
                                <td>{{ $users->where('id', $value->to)->first()->name}}</td>
                                <td>{{ $users->where('id', $value->from)->first()->name}}</td>
                                <td>{{ $value->trip_logs->last()->status }}</td>

                                <!-- we will also add show, edit, and delete buttons -->
                                <td>
                                    @if(Auth::check() & (Auth::User()->id == $value->to | Auth::User()->id == $value->from | Auth::User()->role == "admin"))
                                        <a class="btn btn-small btn-info" href="{{ URL::to('trips/edit/' . $value->id ) }}">Items</a>
                                    @endif
                                    
                                    @if(Auth::check() & (Auth::User()->id == $value->from | Auth::User()->role == "admin"))
                                        <a class="btn btn-small btn-warning" data-toggle="modal" data-target="#ModalUpdate{{ $value->id }}">Update Status</a>
                                    @else
                                        <a class="btn btn-small btn-warning" disabled>Update Status</a>
                                    @endif
                                    
                                </td>
                            </tr>

                            <!-- Modal Example Start-->
                            <div class="modal fade" id="ModalUpdate{{ $value->id }}" value="{{$value->id}}" tabindex="-1" role="dialog" aria- labelledby="ModalUpdateLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalUpdateLabel{{ $value->id }}">Update Trip Status</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{ Form::open( ['route' => ['trip.update', $value->id], 'method' => 'post']) }}
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 col-form-label">To</label>
                                                <div class="col-sm-10">
                                                    @if(Auth::check())
                                                        <input type="text" class="form-control" value="{{$users->where('id', $value->to)->first()->name}}" aria-label="from" disabled>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 col-form-label">From</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" value="{{$users->where('id', $value->from)->first()->name}}" aria-label="from" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 col-form-label">Bag</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" value="{{$value->bag->first()->bag_label}}" aria-label="from" disabled>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="trip_id" value="{{$value->id}}" aria-label="trip_id" hidden>
                                                    <select class="form-select" id="status" name="status">
                                                        <option value="">-- Select Status --</option>
                                                        @if(Auth::check() & (Auth::User()->role == "packaging" | Auth::User()->role == "admin") & $value->trip_logs->last()->status == 'At HQ Packaging')
                                                            <option value="Bag Dispatch To Branch">Dispatch To Branch</option>
                                                        @endif
                                                        @if(Auth::check() & (Auth::User()->role == "branch" | Auth::User()->role == "admin") & $value->trip_logs->last()->status == 'Bag Received At Branch')
                                                            <option value="Bag Dispatch To HQ">Dispatch To HQ</option>
                                                        @endif
                                                        @if(Auth::check() & Auth::User()->role == "admin")
                                                            <option value="At HQ Packaging">At HQ Packaging</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                                            {{ Form::submit('Save', array('class' => 'btn btn-primary col-2')) }}
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Example End-->
                                
                            @endforeach
                            </tbody>
                        </table>
                    <div>
                </div>
            </div>
        </div>
    </div>
    @include('trips.Modal.create')
@endsection
