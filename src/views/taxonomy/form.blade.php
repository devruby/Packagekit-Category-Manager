@extends('hrms.layouts.base')
@section('title', $data['title'])
@section('content')

<section id="content" class="animated fadeIn">
	<div class="mw1000 center-block">
		<div class="row">
            <div class="col-xs-5">
                <div class="box-title" >
                    <h3><i class="fa fa-globe" aria-hidden="true"></i> {{$data['h1']}} </h3>
                </div>
            </div>
        </div>

        <div class="box box-success">
        	<div class="panel">
        		<div class="row allcp-form">
        			<form method="post" action="" id="translate">
        				{!! Form::token() !!}

                        @if($data['page'] == 'project_type')
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><h6 class="mb5 mt10">{{trans('taxonomy.select_project_style')}}</h6></label>
                                    <select class="form-control search name" name="parent_id">
                                        <option value="">{{trans('taxonomy.select_project_style')}}</option>
                                        @if(isset($data['project_style']))
                                        @foreach($data['project_style'] as $key => $value)
                                        <option value="{{$value->ID}}" {{(isset($data['result']) && $data['result']->parent_id == $value->ID)?'selected':''}}>{{$value->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span class="error error_pages"></span>
                                </div>
                            </div>
                        </div>
                        @endif

        				<div class="row">
        					<div class="col-md-3">
				        		<div class="form-group">
				        			<label><h6 class="mb5 mt10">{{trans('taxonomy.taxonomy_name')}}</h6></label>
				        			<input type="text" class="field form-control" placeholder="{{trans('taxonomy.enter_taxonomy_name')}}" style="height:40px" value="{{(isset($data['result']))?$data['result']->name:''}}" name="name">
				        			<span class="error error_code"></span>
				        		</div>
				        	</div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><h6 class="mb5 mt10">{{trans('taxonomy.position')}}</h6></label>
                                    <input type="number" class="field form-control" placeholder="{{trans('taxonomy.enter_position')}}" style="height:40px" value="{{(isset($data['result']))?$data['result']->order:''}}" name="order">
                                    <span class="error error_code"></span>
                                </div>
                            </div>
        				</div>
        				<div class="row">
			        		<div class="col-md-2">
                    			<div class="form-group">
                    				<input type="submit" class="btn btn-primary btn-add" value="{{$data['submit']}}">
                    			</div>
                    		</div>
			        	</div>
        			</form>
        		</div>
        	</div>
        </div>
	</div>
</section>
{{-- <style type="text/css">
    .btn-primary:hover, .btn-primary:focus{
        background-color: #5b4c44 !important;
    }
</style> --}}

@endsection