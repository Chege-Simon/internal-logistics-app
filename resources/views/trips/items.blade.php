@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header row">
                    <div class="col-3">Trips</div>
                    <div class="col-7"></div>
                    @if(Auth::check() & (Auth::User()->id == $trip->from | Auth::User()->role == "admin"))
                    <a class="col-2 btn btn-small btn-primary text-light" data-toggle="modal" data-target="#ModalAdd">Add Item</a>
                    @endif

                    @if(Auth::check() & (Auth::User()->role == "admin" | Auth::User()->role == "branch" | Auth::User()->role == "receiving"))
                    <a class="col-2 btn btn-small btn-success" href="{{ URL::to('trips/receive/' . $trip->id ) }}">Receive</a>
                    @endif
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
                                <td>Item Type</td>
                                <td>Item Code</td>
                                <td>Status</td>
                                <td style="width:45%">Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $key => $value)
                            <tr>
                                <td>{{ $value->item_type}}</td>
                                <td>{{ $value->item_code}}</td>
                                <td>{{ $value->status}}</td>

                                <!-- we will also add show, edit, and delete buttons -->
                                <td>
                                    @if(Auth::check() & (Auth::User()->id == $trip->from | Auth::User()->role == "admin")& $value->status == "In Bag")
                                    <a class="btn btn-small btn-warning" data-toggle="modal" data-target="#ModalUpdate{{ $value->id }}">Edit Item</a>
                                    <a class="btn btn-small btn-danger" onclick="return confirm('Are you sure, you want to delete?')" href="{{ URL::to('items/delete/' . $value->id) }}">Delete Item</a>
                                    @else
                                    <a class="btn btn-small btn-secondary" disabled>Edit Item</a>
                                    <a class="btn btn-small btn-secondary" disabled>Delete Item</a>
                                    @endif
                                    @if(Auth::check() & (Auth::User()->role == "admin" | Auth::User()->role == "receiving" | Auth::User()->role == "branch") & $trip->trip_logs->last()->status == 'Received At Branch' & $value->status == "Sent")
                                    <a class="btn btn-small btn-success" href="{{ URL::to('items/receive/'.$value->id) }}">Received</a>
                                    <a class="btn btn-small btn-warning" href="{{ URL::to('items/not_receive/'.$value->id) }}">Not Received</a>
                                    @elseif(Auth::check() & (Auth::User()->role == "admin" | Auth::User()->role == "receiving" | Auth::User()->role == "branch"))
                                    <a class="btn btn-small btn-secondary" disabled>Received</a>
                                    <a class="btn btn-small btn-secondary" disabled>Not Received</a>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Example Start-->
                            <div class="modal fade" id="ModalUpdate{{ $value->id }}" value="{{$value->id}}" tabindex="-1" role="dialog" aria- labelledby="ModalUpdateLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ModalUpdateLabel{{ $value->id }}">Update Item Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{ Form::open( ['route' => ['item.update', $value->id], 'method' => 'post']) }}
                                            <input type="text" name="trip_id" id="trip_id" aria-label="trip_id" value="{{ $value->trip_id }}" autocomplete="on" hidden>
                                            <div class="form-group row">
                                                <label for="status" class="col-sm-5 col-form-label">Item Type</label>
                                                <div class="col-sm-12">
                                                    <select class="form-select" id="item_type" name="item_type" autocomplete="{{$value->item_type}}">
                                                        <option value="">-- Select Item Type --</option>
                                                        <option value="Order">Order</option>
                                                        <option value="ITR">ITR</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-5 col-form-label">Item Code</label>
                                                <small class="text-muted col-sm-10">Note: For Item Type "Other" fill with description</small>
                                                <div class="col-sm-12">
                                                    <input type="text" name="item_code" id="item_code" aria-label="item_code" value="{{$value->item_code}}">
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
                        <div class="card-footer row">
                            <div class="col-10"></div>
                            <a class="col-2 btn btn-small btn-secondary text-light" href="/trips/">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('trips.Modal.add')
        @endsection