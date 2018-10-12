@extends('hrms.layouts.base')
@section('title', $datas['title'])
@section('content')
<section id="content" class="table-layout animated fadeIn">
	<div class="chute chute-center">
		<div class="row">
			<div class="col-xs-12">
				<div class="box-title wrap-title">
                    <h1><i class="fa fa-globe" aria-hidden="true" style="margin-right: 10px;"></i>{{$datas['h1']}}</h1>
                </div>
                <div class="box box-success">
                	<div class="panel">
                		<div class="panel-heading">
                			<a style="margin-right: 15px;" href="{{$datas['button_add_link']}}" target="_blank" class="btn btn-primary btn-font-size btn-add"><i class="fa fa-plus" aria-hidden="true"></i> {{$datas['button_add']}}</a>
                		</div>
	                	<br/>
	                	{!! Form::token() !!}
	                	<div class="panel-menu allcp-form theme-primary mtn">
	                		<div class="row">
	                			{!! Form::open(['method' => 'GET']) !!}
		                		<div class="col-md-4">
		                    		<div class="form-group">
		                    			<label><h6 class="mb5 mt10">{{trans('taxonomy.taxonomy_name')}}</h6></label>
		                    			<input type="text" class="field form-control" placeholder="{{trans('taxonomy.enter_taxonomy_name')}}" style="height:40px" value="{{(isset($_GET['name']) && $_GET['name']) ? $_GET['name'] : ''}}" name="name">
		                    		</div>
		                    	</div>

	                    		<div class="col-md-2" style="padding-right: 0px;">
	                    			<div class="form-group">
	                    				<label style="width: 100%;"><h6 class="mb5 mt10" style="color: transparent;">{{trans('taxonomy.search')}}</h6></label>
	                    				<button type="submit" value="Search" name="search" class="btn btn-success" style="width: 100%;">{{trans('taxonomy.search')}}</button>
	                    			</div>
	                    		</div>
	                    		{!! Form::close() !!}

	                    		<div class="col-md-2">
                        			<div class="form-group">
                        				<label style="width: 100%;"><h6 class="mb5 mt10" style="color: transparent;">{{trans('taxonomy.remove_filters')}}</h6></label>
                        				<a href="{{$datas['current_url']}}" >
                                        <input type="submit" value="{{trans('hrm.search_undo')}}" class="btn btn-warning" style="color:#fff"></a>
                        			</div>
                        		</div>

	                		</div>
	                	</div>

	                	<div class="panel-body pn">
	                		<div  id="alert-success" class="alert alert-success hidden">
                            </div>

                            <div class="table-responsive">
                            	<table class="table allcp-form theme-warning tc-checkbox-1 fs13 table-bordered tablesorter ">
                            		<thead>
                                        <tr class="bg-light" >
                                            <th class="text-center">{{trans('taxonomy.position')}}</th>
                                            <th class="text-center">{{trans('taxonomy.taxonomy_name')}}</th>
                                            @if($datas['page'] == 'project_type')
                                            <th class="text-center">{{trans('taxonomy.project_style')}}</th>
                                            @endif
                                            <th class="text-center thaotac">{{trans('taxonomy.actions')}}</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    	@if(count($datas['results']) > 0)
                                    	@foreach($datas['results'] as $item)
                                    	<tr>
                                    		<td class="text-center">{{$item->order}}</td>
                                    		<td class="text-center">{{$item->name}}</td>
                                            @if($datas['page'] == 'project_type')
                                            <td class="text-center">{{\App\Http\Controllers\FunctionsController::getProjectStyle($item->parent_id)}}</td>
                                            @endif
                                    		<td class="text-center actions">
                                                <a href="{{$datas['button_add_link']}}?edit={{$item->ID}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a href="javascript:void(0);" class="td-delete" data-id="{{$item->ID}}" data-table="taxonomy"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            </td>
                                    	</tr>
                                    	@endforeach
                                    	@else
                                    	<tr>
                                            <td colspan="10">{{trans('taxonomy.no_results')}}</td>
                                        </tr>
                                    	@endif
                                    </tbody>
                            	</table>
                            </div>
	                	</div>
                	</div>
                </div>
			</div>
		</div>
	</div>
	
</section>

@endsection