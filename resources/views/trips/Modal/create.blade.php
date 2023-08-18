
<!-- Modal -->
<div class="modal fade" id="ModalCreate" tabindex="-1" aria-labelledby="ModalCreate" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCreateLabel">Record Trip</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::open( ['route' => ['trip.store'], 'method' => 'post']) }}
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">from</label>
                    <div class="col-sm-10">
                        @if(Auth::check())
{{--
                            {!! Form::text('from', Auth::user()->name, ['class' => 'form-control', 'id' => 'from', 'disabled', 'value' => Auth::user()->id]) !!}
--}}
                            <input type="text" name="from" value="{{Auth::user()->id}}" aria-label="from" hidden>
                            <input type="text" class="form-control" value="{{Auth::user()->name}}" aria-label="from" disabled>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">to</label>
                    <div class="col-sm-10">
                        @if(Auth::check() & (Auth::User()->role == "packaging" | Auth::User()->role == "admin"))
                            {!! Form::select('to', $branches, null, ['class' => 'form-control', 'id' => 'to']) !!}
                        @else if(Auth::check() & (Auth::User()->role == "branch"| Auth::User()->role == "admin"))
                            <select class="form-select" id="to" name="to">
                                @foreach ($users->where('role','like', 'receiving') as $receiving)
                                    <option value="{{ $receiving->id }}">{{ $receiving->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Bag</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="bag_id" name="bag_id">
                            @foreach($bags as $bag)
                                <option value="{{ $bag->id }}">{{ $bag->user->name }} ({{ $bag->bag_label }})</option>
                            @endforeach
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
