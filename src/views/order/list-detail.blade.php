@extends('hrms.layouts.base')
@section('title', $data->title)
@section('content')
    <style>
        .full-width{
            width: 100%;
        }

        .margin-top-35{
            margin-top: 35px;
        }
    </style>
    <section id="content" class="table-layout animated fadeIn">
        <div class="chute chute-center">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-title wrap-title">
                        <h1><i class="fa fa-globe" aria-hidden="true" style="margin-right: 10px;"></i>{{ $data->title }}</h1>
                    </div>
                    <div class="box box-success">
                        <div class="panel">
                            {{--<div class="panel-heading">--}}
                                {{--<a style="margin-right: 15px;" href="{!! asset('order/add') !!}" class="btn btn-primary btn-font-size btn-add"><i class="fa fa-plus" aria-hidden="true"></i> {{trans('taxonomy.add_new')}}</a>--}}
                            {{--</div>--}}
                            {{--<br/>--}}
                            <div class="panel-menu allcp-form theme-primary mtn">
                                {!! Form::open(['method' => 'GET']) !!}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><h6 class="mb5 mt10">{{trans('order.user_name')}}</h6></label>
                                            <select class="search form-control" name="user_id">
                                                <option value="">{{trans('hrm.select')}}</option>
                                                @if(isset($data->emp) && $data->emp)
                                                    @foreach($data->emp as $item)
                                                        <option value="{{$item->id}}" {{( isset($_GET['user_id']) && $item->id == $_GET['user_id']  ? 'selected' : null) }}>{{$item->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><h6 class="mb5 mt10">{{trans('order.code_order')}}</h6></label>
                                            <input type="text" class="field form-control" name="code_order"  placeholder="{{trans('order.code_order')}}" style="height:40px" value="{{(isset($_GET['code_order']) && $_GET['code_order']) ? $_GET['code_order'] : null }}" >
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><h6 class="mb5 mt10">{{trans('order.search_type')}}</h6></label>
                                            <select class="search form-control" name="type_id">
                                                <option value="">{{trans('hrm.select')}}</option>
                                                @if(isset($data->ldm) && $data->ldm)
                                                    @foreach($data->ldm as $item)
                                                        <option value="{{$item->ID}}" {{( isset($_GET['type_id']) && $item->ID == $_GET['type_id']  ? 'selected' : null) }}>{{$item->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>






                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><h6 class="mb5 mt10">{{trans('order.search_part')}}</h6></label>
                                            <select class="search form-control" name="part_id">
                                                <option value="">{{trans('hrm.select')}}</option>
                                                @if(isset($data->bp) && $data->bp)
                                                    @foreach($data->bp as $item)
                                                        <option value="{{$item->ID}}" {{( isset($_GET['part_id']) && $item->ID == $_GET['part_id']  ? 'selected' : null) }}>{{$item->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="padding-right: 0px;">
                                        <div class="form-group margin-top-35">
                                            {{--<label class=""><h6 class="mb5 mt10">{{trans('order.search_part')}}</h6></label>--}}
                                            <button type="submit" value="Search" class="btn btn-success" style="width: 100%;">{{trans('taxonomy.search')}}</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group margin-top-35">
                                            {{--<label><h6 class="mb5 mt10">{{trans('order.search_part')}}</h6></label>--}}
                                            <a href="{!! asset('/order/index-detail') !!}" class="btn btn-warning full-width">
                                            {{trans('hrm.search_undo')}}
                                                {{--<input type="submit" value="{{trans('hrm.search_undo')}}" class="btn btn-warning" style="color:#fff">--}}
                                                </a>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="panel-body pn ">
                                <div  id="alert-success" class="alert alert-success hidden">
                                </div>

                                <div class="table-responsive">
                                    <table class="table allcp-form theme-warning tc-checkbox-1 fs13 table-bordered tablesorter ">
                                        <thead>
                                            <tr class="bg-light" >
                                                <th class="text-center">{{trans('order.order_id')}}</th>
                                                <th class="text-center">{{trans('taxonomy.type')}}</th>
                                                <th class="text-center">{{trans('taxonomy.part')}}</th>
                                                <th class="text-center">{{trans('order.user_name')}}</th>
                                                <th class="text-center">{{trans('order.code_order')}}</th>
                                                <th class="text-center thaotac">{{trans('taxonomy.actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($data->list) && count($data->list))
                                            @foreach($data->list as $item)
                                                <tr>
                                                    <td class="text-center">
                                                        {!! (isset($item->order_id) && $item->order_id ? $item->order_id : null) !!}
                                                    </td>

                                                    <td class="text-center">
                                                        {!! (isset($item->orders->type->name) && $item->orders->type->name ? $item->orders->type->name : null) !!}
                                                    </td>

                                                    <td class="text-center">
                                                        {!! (isset($item->orders->part->name) && $item->orders->part->name ? $item->orders->part->name : null) !!}
                                                    </td>

                                                    <td class="text-center">
                                                        {!! (isset($item->user->name) && $item->user->name ? $item->user->name : null) !!}
                                                    </td>

                                                    <td class="text-center">
                                                        {!! (isset($item->code_order) && $item->code_order ? $item->code_order : null) !!}
                                                    </td>
                                                    <td class="text-center actions">
                                                        <a href="javascript:void(0)" class="click-popup" data-id="{!! $item->id !!}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        <a href="{{asset('order/edit-detail/'. $item->id)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a href="{{asset('order/delete-detail/'. $item->id )}}" onClick="return confirm('Bạn muốn xóa ?');" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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

    {{--Modal show của Order--}}
    <div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>
    {{--End Modal show của Order--}}
@endsection

@section('script')
    <script>
        $( document ).ready(function() {
            // $( ".purchase_date" ).datepicker({ dateFormat: 'dd/mm/yy' });

            $('.click-popup').on('click', function () {
                var id  = $(this).data('id');
                var url = '{!! asset('ajax/order-detail-show') !!}/' + id;
                $.get( url , function( data ) {
                    if(data){
                        $('#myModal').find('.modal-content').html(data);
                        $('#myModal').modal('show');
                    }
                });
            });
        });
    </script>
@endsection