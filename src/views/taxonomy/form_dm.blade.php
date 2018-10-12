<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label><h6 class="mb5 mt10">{{trans('taxonomy.cat_name')}} <i class="required">*</i></h6></label>
            <input type="text" class="field form-control" name="name" value="{!! (isset($data->name) && $data->name) ? $data->name : null !!}" required>
            <span class="error error_pages"></span>
        </div>
    </div>
</div>
<input type="hidden" name="url" value="{!! (isset($data->taxonomy_type) && $data->taxonomy_type)  ? $data->taxonomy_type : $slug !!}">