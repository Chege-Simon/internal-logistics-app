@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header row">
                    <div class="col-3">Bags</div>
                    <div class="col-7"></div>
                    <a class="col-2 btn btn-small btn-primary text-light" href="{{ URL::to('bag/create') }}">Register Bag</a>
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
                                <td>Branch</td>
                                <td>Bag Label</td>
                                <td>current status</td>
                                <td style="width: 15%;">Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bags as $key => $value)
                            <tr>
                                <td>{{ $value->user->name}}</td>
                                <td>{{ $value->bag_label }}</td>
                                @if(count($value->trip->trip_logs) > 0)
                                <td>{{ $value->trip->trip_logs->last()->status }}</td>
                                @endif

                                <!-- we will also add show, edit, and delete buttons -->
                                <td>
                                    <a class="btn btn-small btn-info" href="{{ URL::to('bags/edit/' . $value->id ) }}">Edit</a>
                                    <a class="btn btn-small btn-danger" onclick="return confirm('Are you sure, you want to delete?')" href="{{ URL::to('bags/delete/' . $value->id) }}">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                    </div>
                </div>
            </div>
        </div>
        @endsection