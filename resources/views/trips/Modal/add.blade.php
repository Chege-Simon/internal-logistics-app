
<!-- Modal -->
<div class="modal fade" id="ModalAdd" tabindex="-1" aria-labelledby="ModalAdd" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalAddLabel">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::open( ['route' => ['item.store'], 'method' => 'post']) }}
                <input type="text" name="trip_id" id="trip_id" aria-label="trip_id" value="{{ $trip->id }}" hidden>
                <div class="form-group row">
                    <label for="status" class="col-sm-5 col-form-label">Item Type</label>
                    <div class="col-sm-12">
                        <select class="form-select" id="item_type" name="item_type">
                            <option value="">-- Select tem Type --</option>
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
                        <input type="text" name="item_code" id="item_code" aria-label="item_code" >
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
