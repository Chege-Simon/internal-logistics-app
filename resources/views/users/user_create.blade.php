@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Creation</div>
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
                    {{ Form::open( ['route' => ['user.store'], 'method' => 'post']) }}
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            {{ Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="role" name="role">
                                <option value="">-- Select Role --</option>
                                <option value="0">Admin</option>
                                <option value="1">Packaging</option>
                                <option value="2">Receiving</option>
                                <option value="3">Branch</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                        <div class="col-md-8">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        <div class="col-md-8">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="card-footer row">
                        {{ Form::submit('Save', array('class' => 'btn btn-primary col-2')) }}
                        <div class="col-8"></div>
                        <a class="col-2 btn btn-small btn-secondary text-light" href="{{ URL::to('users') }}">Back</a>
                    </div>
                    {{ Form::close() }}
                    <div>
                    </div>
                </div>
            </div>
        </div>
        @endsection