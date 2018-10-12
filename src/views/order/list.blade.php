@extends('hrms.layouts.base')
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
                                <a style="margin-right: 15px;" href="{!! asset('order/add') !!}" class="btn btn-primary btn-font-size btn-add"><i class="fa fa-plus" aria-hidden="true"></i> {{trans('taxonomy.add_new')}}</a>
                            </div>
                            <br/>
                                <div class="panel-menu allcp-form theme-primary mtn">
                                    <div class="row">
                                        {!! Form::open(['method' => 'GET']) !!}
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><h6 class="mb5 mt10">{{trans('order.search_order_id')}}</h6></label>
                                                <select class="search form-control" name="id">
                                                    <option value="">{{trans('hrm.select')}}</option>
                                                    @foreach($data->list_search as $item)
                                                        <option value="{{$item->id}}" {{( isset($_GET['id']) && $item->id == $_GET['id']  ? 'selected' : null) }}>{{$item->id}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><h6 class="mb5 mt10">{{trans('order.search_bp')}}</h6></label>
                                                <select class="search form-control" name="part_id">
                                                    <option value="">{{trans('hrm.select')}}</option>
                                                    @foreach($data->bp as $item)
                                                        <option value="{{$item->ID}}" {{( isset($_GET['part_id']) && $item->ID == $_GET['part_id']  ? 'selected' : null) }}>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><h6 class="mb5 mt10"> {{trans('order.guarantee')}} <i
                                                                class="required">*</i></h6></label>
                                                <div class="input-group" data-provide="datepicker">
                                                    <input type="text" name="guarantee" id="guarantee"
                                                           class="form-control purchase_date"
                                                           placeholder="dd/mm/yyyy"
                                                           value="{!! (isset($_GET['guarantee']) && $_GET['guarantee'] ? $_GET['guarantee'] : null )  !!}"
                                                    >
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2" style="padding-right: 0px;">
                                            <div class="form-group">
                                                <button type="submit" value="Search" class="btn btn-success" style="width: 100%;">{{trans('taxonomy.search')}}</button>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <a href="{!! asset('/order/index') !!}" >
                                                    <input type="submit" value="{{trans('hrm.search_undo')}}" class="btn btn-warning" style="color:#fff"></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <div class="panel-body pn ">
                                <div  id="alert-success" class="alert alert-success hidden">
                                </div>

                                <div class="table-responsive">
                                    <table class="table allcp-form theme-warning tc-checkbox-1 fs13 table-bordered tablesorter ">
                                        <thead>
                                        <tr class="bg-light" >
                                            <th class="text-center">{{trans('taxonomy.id')}}</th>
                                            <th class="text-center">{{trans('taxonomy.category')}}</th>
                                            <th class="text-center">{{trans('taxonomy.type')}}</th>
                                            <th class="text-center">{{trans('taxonomy.part')}}</th>
                                            <th class="text-center">{{trans('order.config')}}</th>
                                            <th class="text-center">{{trans('order.amount')}}</th>
                                            <th class="text-center">{{trans('order.guarantee')}}</th>
                                            <th class="text-center thaotac">{{trans('taxonomy.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($data->list) && count($data->list))
                                            @foreach($data->list as $item)
                                                <tr>
                                                    <td class="text-center">
                                                        {!! (isset($item->id) && $item->id ? $item->id : null) !!}
                                                    </td>

                                                    <td class="text-center">
                                                        {!! (isset($item->category->name) && $item->category->name ? $item->category->name : null) !!}
                                                    </td>

                                                    <td class="text-center">
                                                        {!! (isset($item->type->name) && $item->type->name ? $item->type->name : null) !!}
                                                    </td>

                                                    <td class="text-center">
                                                        {!! (isset($item->part->name) && $item->part->name ? $item->part->name : null) !!}
                                                    </td>

                                                    <td class="text-center">
                                                        {!! (isset($item->config) && $item->config ? $item->config : null) !!}
                                                    </td>

                                                    <td class="text-center">
                                                        {!! (isset($item->amount) && $item->amount ? $item->amount : null) !!}
                                                    </td>

                                                    <td class="text-center">
                                                        {!! (isset($item->guarantee) && $item->guarantee ? $item->guarantee : null) !!}
                                                    </td>
                                                    <td class="text-center actions">
                                                        <a href="javascript:void(0)" class="click-popup" data-id="{!! $item->id !!}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        <a href="{{asset('order/edit/'. $item->id)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <a href="{{asset('order/delete/'. $item->id )}}" onClick="return confirm('Bạn muốn xóa ?');" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
            $( ".purchase_date" ).datepicker({
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                showButtonPanel: false,
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true,
                yearRange: '1970:{!! Carbon\Carbon::today()->format('Y') !!}',
            });

            $('.click-popup').on('click', function () {
                var id  = $(this).data('id');
                var url = '{!! asset('ajax/order-show') !!}/' + id;
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