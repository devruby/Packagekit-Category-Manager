<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label><h6 class="mb5 mt10">{{trans('taxonomy.cat_name')}} <i class="required">*</i></h6></label>
            <select class="form-control search dm" name="parent_dm" required>
                <option value="">{{trans('hrm.select')}}</option>
                @if(isset($list_cat))
                    @foreach($list_cat as $value)
                        <option value="{{$value->ID}}" {!! (isset($data->parent->parent->ID) && $data->parent->parent->ID ==  $value->ID ? 'selected' : null) !!}>{{$value->name}}</option>
                    @endforeach
                @endif
            </select>
            <span class="error error_pages"></span>
        </div>
    </div>
    <input type="hidden" name="url" value="{!! (isset($data->taxonomy_type) && $data->taxonomy_type) ? $data->taxonomy_type : $slug !!}">
    <div class="col-md-3">
        <div class="form-group">
            <label><h6 class="mb5 mt10">{{trans('taxonomy.cat_loai')}}</h6></label>
            <select class="form-control search loai" name="parent_id">
                <option value="" >{{trans('hrm.select')}}</option>
                @if(isset($list_type))
                    @foreach($list_type as $value)
                        <option value="{{$value->ID}}" {!! (isset($data->parent->ID) && $data->parent->ID ==  $value->ID ? 'selected' : null) !!}>{{$value->name}}</option>
                    @endforeach
                @endif
            </select>
            <span class="error error_pages"></span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label><h6 class="mb5 mt10">{{trans('taxonomy.cat_bp')}}</h6></label>
            <input type="text" class="field form-control" name="name" value="{!! (isset($data->name) && $data->name) ? $data->name : null !!}">
            <span class="error error_pages"></span>
        </div>
    </div>
</div>