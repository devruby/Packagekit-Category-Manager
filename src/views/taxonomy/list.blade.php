@extends('CategoryManager::layouts.base')
@section('title', $data->title)
@section('content')
    <section id="content" class="table-layout animated fadeIn">
        <div class="chute chute-center">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-title wrap-title">
                        <h1><i class="fa fa-globe" aria-hidden="true" style="margin-right: 10px;"></i>{{ $data->title }}</h1>
                    </div>
                    <div class="box box-success">
                        <div class="panel">
                            <div class="panel-heading">
                                <a style="margin-right: 15px;" href="{!! asset('taxonomy/add-category/'. $data->slug) !!}" class="btn btn-primary btn-font-size btn-add"><i class="fa fa-plus" aria-hidden="true"></i> {{trans('taxonomy.add_new')}}</a>
                            </div>
                            <br/>
                            @if($data->slug == 'bo-phan')
                                <div class="panel-menu allcp-form theme-primary mtn">
                                    <div class="row">
                                        {!! Form::open(['method' => 'GET']) !!}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><h6 class="mb5 mt10">{{trans('taxonomy.taxonomy_type')}}</h6></label>
                                                <select class="search form-control" name="type_id">
                                                    <option value="">{{trans('hrm.select')}}</option>
                                                    @if(isset($data->dml) && $data->dml)
                                                        @foreach($data->dml as $item)
                                                            <option value="{{$item->ID}}" {{( isset($_GET['type_id']) && $item->ID == $_GET['type_id']  ? 'selected' : null) }}>{{$item->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><h6 class="mb5 mt10">{{trans('taxonomy.taxonomy_name')}}</h6></label>
                                                <input type="text" class="field form-control" placeholder="{{trans('taxonomy.enter_taxonomy_name')}}" style="height:40px" value="{{(isset($_GET['name']) && $_GET['name']) ? $_GET['name'] : ''}}" name="name">
                                            </div>
                                        </div>

                                        <div class="col-md-2" style="padding-right: 0px;">
                                            <div class="form-group">
                                                <label style="width: 100%;"><h6 class="mb5 mt10" style="color: transparent;">{{trans('taxonomy.search')}}</h6></label>
                                                <button type="submit" value="Search" class="btn btn-success" style="width: 100%;">{{trans('taxonomy.search')}}</button>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label style="width: 100%;"><h6 class="mb5 mt10" style="color: transparent;">{{trans('taxonomy.remove_filters')}}</h6></label>
                                                <a href="{!! asset('/taxonomy/list-category/'. $data->slug) !!}" >
                                                    <input type="submit" value="{{trans('hrm.search_undo')}}" class="btn btn-warning" style="color:#fff"></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif
                            <div class="panel-body pn {!! ($data->slug != 'bo-phan') ? 'no-margin' : null !!}">
                                <div  id="alert-success" class="alert alert-success hidden">
                                </div>

                                <div class="table-responsive">
                                    <table class="table allcp-form theme-warning tc-checkbox-1 fs13 table-bordered tablesorter ">
                                        <thead>
                                        <tr class="bg-light" >
                                            <th class="text-center">{{trans('taxonomy.taxonomy_dm')}}</th>

                                            @if($data->slug == 'loai' || $data->slug == 'bo-phan')
                                                <th class="text-center">{{trans('taxonomy.taxonomy_l')}}</th>
                                            @endif

                                            @if($data->slug == 'bo-phan')
                                                <th class="text-center">{{trans('taxonomy.taxonomy_bp')}}</th>
                                            @endif

                                            <th class="text-center thaotac">{{trans('taxonomy.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($data->list) && count($data->list))
                                            @foreach($data->list as $item)
                                                <tr>
                                                    <td class="text-center">
                                                        @if($item->taxonomy_type == 'danh-muc')
                                                            {{ $item->name }}
                                                        @elseif($item->taxonomy_type == 'loai')
                                                            {{ (isset($item->parent->name) && $item->parent->name) ? $item->parent->name :null }}
                                                        @elseif($item->taxonomy_type == 'bo-phan')
                                                            @if(isset($item->parent->taxonomy_type) && $item->parent->taxonomy_type == 'loai')
                                                                {{ (isset($item->parent->parent->name) && $item->parent->parent->name) ? $item->parent->parent->name :null }}
                                                            @else
                                                                {{ (isset($item->category->name) && $item->category->name) ? $item->category->name :null }}
                                                            @endif

                                                        @endif
                                                    </td>

                                                    @if($item->taxonomy_type == 'loai')
                                                        <td>
                                                            {{ (isset($item->name) && $item->name) ? $item->name : null }}
                                                        </td>
                                                    @elseif($item->taxonomy_type == 'bo-phan')
                                                        <td>
                                                            {{ (isset($item->part->name) && $item->part->name) ? $item->part->name : null }}
                                                        </td>
                                                    @endif

                                                    @if($item->taxonomy_type == 'bo-phan')
                                                        <td>
                                                            {{ (isset($item->name) && $item->name) ? $item->name : null }}
                                                        </td>
                                                    @endif
                                                    <td class="text-center actions">
                                                        <a href="{{asset('taxonomy/edit-category/'. $item->ID)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a href="{{asset('taxonomy/delete-category/'. $item->ID )}}" onClick="return confirm('Bạn muốn xóa ?');" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
                                    {!! $data->list->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection