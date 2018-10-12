<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label><h6 class="mb5 mt10">{{trans('taxonomy.cat_name')}} <i class="required">*</i></h6>   </label>
            <select class="form-control search name" name="parent_id" required>
                <option value="">{{trans('hrm.select')}}</option>
                @if(isset($list_cat))
                    @foreach($list_cat as $value)
                        <option value="{{$value->ID}}" {!! (isset($data->ID) && $data->ID) ? 'selected' : null !!}>{{$value->name}}</option>
                    @endforeach
                @endif
            </select>
            <span class="error error_pages"></span>
        </div>
    </div>
    <input type="hidden" name="url" value="{!! (isset($data->taxonomy_type) && $data->taxonomy_type) ? $data->taxonomy_type : $slug!!}">
    <div class="col-md-3">
        <div class="form-group">
            <label><h6 class="mb5 mt10">{{trans('taxonomy.cat_loai')}} </h6></label>
            <input type="text" class="field form-control" name="name" value="{!! (isset($data->name) && $data->name) ? $data->name : null !!}" >
            <span class="error error_pages"></span>
        </div>
    </div>
</div>