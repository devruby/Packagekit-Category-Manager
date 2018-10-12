<div class="row">
    <div class="col-md-6 allcp-form tleft">
        <div class="form-group">
            <label><h6 class="mb5 mt10"> {{trans('order.user_id')}} </h6></label>
                <select class="select2-single form-control dm" name="user_id">
                    <option value="">{!! trans('hrm.select') !!}</option>
                    @if(isset($data->emp) && $data->emp)
                        @foreach($data->emp as $val)
                            <option value="{{$val->id}}" {!! (isset($data->list->user_id) && $data->list->user_id == $val->id ? 'selected' : null) !!}>{{$val->name}}</option>
                        @endforeach
                    @endif
                </select>
        </div>
    </div>

    <div class="col-md-6 allcp-form tright">
        <div class="form-group">
            <label><h6 class="mb5 mt10"> {{trans('order.code_order')}} <i
                            class="required">*</i></h6></label>
            <input type="text" name="code_order" id="code_order"
                   class="form-control code_order"
                   value="{!! (isset($data->list->code_order) && $data->list->code_order ? $data->list->code_order : null) !!}" >
        </div>
        <label for="amount" generated="true" class="error "></label>
    </div>
</div>

<div class="row">
    <div class="col-md-12 allcp-form">
        <div class="form-group">
            <label><h6 class="mb5 mt10"> {{trans('order.note')}} </h6></label>
            <textarea name="note" id="note"
                   class="form-control note" rows="4"
            >{!! (isset($data->list->note) && $data->list->note ? $data->list->note : null)  !!}</textarea>
        </div>
    </div>

</div>

<div class="form-group margin-top-20">
    <label class="col-md-4 control-label"></label>
    <div class="col-md-2">
        <input type="submit" class="btn btn-primary btn-block"
               value="{{trans('hrm.submit')}}">
    </div>
    <div class="col-md-2"><a href="{!! asset('order/index') !!}">
            <input type="button" class="btn btn-danger btn-block"
                   value="{{trans('hrm.cancel')}}"></a>
    </div>
</div>