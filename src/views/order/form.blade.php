<div class="row">
    <div class="col-md-6 allcp-form tleft">
        <div class="form-group">
            <label><h6 class="mb5 mt10"> {{trans('taxonomy.cat_name')}} <i class="required">*</i></h6></label>
            <label class="field select">
                <select class="select2-single form-control dm" name="category_id" required>
                    <option value="">{!! trans('hrm.select') !!}</option>
                    @if(isset($data->dm) && $data->dm)
                        @foreach($data->dm as $val)
                            <option value="{{$val->ID}}" {!! (isset($data->list->category_id) && $data->list->category_id == $val->ID ? 'selected' : null) !!}>{{$val->name}}</option>
                        @endforeach
                    @endif
                </select>
                <i class="arrow double"></i>
            </label>
            <label for="interview_result" generated="true"
                   class="error "></label>
        </div>
    </div>

    <div class="col-md-6 allcp-form tright">
        <div class="form-group">
            <label><h6 class="mb5 mt10"> {{trans('taxonomy.cat_type')}} </h6></label>
            <label class="field select">
                <select class="select2-single form-control ldm loai" name="type_id">
                    <option value="">{!! trans('hrm.select') !!}</option>
                    @if(isset($data->ldm) && $data->ldm)
                        @foreach($data->ldm as $val)
                            <option value="{{$val->ID}}" {!! (isset($data->list->type_id) && $data->list->type_id == $val->ID ? 'selected' : null) !!}>{{$val->name}}</option>
                        @endforeach
                    @endif
                </select>
                <i class="arrow double"></i>
            </label>
            <label for="interview_result" generated="true"
                   class="error "></label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 allcp-form tleft">
        <div class="form-group">
            <label><h6 class="mb5 mt10"> {{trans('taxonomy.cat_part')}} <i class="required">*</i></h6></label>
            <label class="field select">
                <select class="select2-single form-control bo-phan" name="part_id" required>
                    <option value="">{!! trans('hrm.select') !!}</option>
                    @if(isset($data->bp) && $data->bp)
                        @foreach($data->bp as $val)
                            <option value="{{$val->ID}}" {!! (isset($data->list->part_id) && $data->list->part_id == $val->ID ? 'selected' : null) !!}>{{$val->name}}</option>
                        @endforeach
                    @endif
                </select>
                <i class="arrow double"></i>
            </label>
            <label for="interview_result" generated="true"
                   class="error "></label>
        </div>
    </div>
    <div class="col-md-6 allcp-form tright">
        <div class="form-group">
            <label><h6 class="mb5 mt10"> {{trans('order.config')}} </h6></label>
            <input type="text" name="config" id="config"
                   class="form-control"
                   value="{!! (isset($data->list->config) && $data->list->config ? $data->list->config : null) !!}"
                   >
        </div>
        <label for="config" generated="true" class="error "></label>
    </div>
</div>

<div class="row">
    <div class="col-md-6 allcp-form tleft">
        <div class="form-group">
            <label><h6 class="mb5 mt10"> {{trans('order.amount')}} <i
                            class="required">*</i></h6></label>
            <input type="text" name="amount" id="amount"
                   class="form-control amount" required
                   value="{!! (isset($data->list->amount) && $data->list->amount ? $data->list->amount : null) !!}" >
        </div>
        <label for="amount" generated="true" class="error "></label>
    </div>

    <div class="col-md-6 allcp-form tright">
        <div class="form-group">
            <label><h6 class="mb5 mt10"> {{trans('order.purchase_date')}}</h6></label>
            <div class="input-group">
                <input type="text" name="purchase_date" id="purchase_date"
                       class="form-control purchase_date"
                       value="{!! (isset($data->list->purchase_date) && $data->list->purchase_date ? $data->list->purchase_date : Carbon\Carbon::now()->format('d/m/Y'))  !!}"
                       >
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
            </div>
            <label for="purchase_date" generated="true" class="error "></label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 allcp-form tleft">
        <div class="form-group">
            <label><h6 class="mb5 mt10"> {{trans('order.price')}}</h6></label>
            <input type="text" name="price" id="price"
                   value="{!! (isset($data->list->price) && $data->list->price ? $data->list->price : null)  !!}"
                   class="form-control price"
                   >
        </div>
        <label for="price" generated="true" class="error "></label>
    </div>

    <div class="col-md-6 allcp-form tright">
        <div class="form-group">
            <label><h6 class="mb5 mt10"> {{trans('order.guarantee')}}</h6></label>
            <div class="input-group" >
                <input type="text" name="guarantee" id="guarantee"
                       class="form-control purchase_date"
                       value="{!! (isset($data->list->guarantee) && $data->list->guarantee ? $data->list->guarantee : Carbon\Carbon::now()->format('d/m/Y'))  !!}"
                       >
                <div class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </div>
            </div>
        </div>
        <label for="guarantee" generated="true" class="error "></label>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 allcp-form tleft">
        <div class="form-group">
            <label><h6 class="mb5 mt10"> {{trans('order.phone_number')}}</h6></label>
            <input type="text" name="phone_number" id="phone_number"
                   class="form-control phone_number"
                   value="{!! (isset($data->list->phone_number) && $data->list->phone_number ? $data->list->phone_number : null)  !!}"
                   >
        </div>
        <label for="phone_number" generated="true" class="error "></label>
    </div><!-- /.col-lg-6 -->

    <div class="col-md-6 allcp-form tright">
        <div class="form-group">
            <label><h6 class="mb5 mt10"> {{trans('order.address')}} </h6></label>
            <input type="text" name="address" id="address"
                   class="form-control address"
                   value="{!! (isset($data->list->address) && $data->list->address ? $data->list->address : null)  !!}"
                   >
        </div>
        <label for="address" generated="true" class="error "></label>
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