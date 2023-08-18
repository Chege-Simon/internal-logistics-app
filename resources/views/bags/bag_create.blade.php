@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Bag Creation</div>
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
                        {{ Form::open( ['route' => ['bag.store'], 'method' => 'post']) }}
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Branch</label>
                            <div class="col-sm-10">
                                {!! Form::select('user_id', $branches, null, ['class' => 'form-control', 'id' => 'branch']) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Bag Label</label>
                            <div class="col-sm-10">
                                {{ Form::text('bag_label', null, ['class' => 'form-control', 'id' => 'bag_label']) }}
                            </div>
                        </div>

                        <div class="card-footer row">
                            {{ Form::submit('Save', array('class' => 'btn btn-primary col-2')) }}
                            <div class="col-8"></div>
                            <a class="col-2 btn btn-small btn-secondary text-light"
                               href="{{ URL::to('bags') }}">Back</a>
                        </div>
                        {{ Form::close() }}
                        <div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
