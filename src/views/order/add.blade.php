@extends('hrms.layouts.base')
@section('title', $data->title)
@section('content')
    <!-- START CONTENT -->
    <div class="content">
        <!-- -------------- Content -------------- -->
        <section id="content" class="animated fadeIn">
            <!-- -------------- Column Center -------------- -->
            <div class="row ">
                <div class="col-xs-12">
                    <div class="box-title">
                        <h3><i class="fa fa-user" aria-hidden="true"></i> {{ isset($data->list) && $data->list ? trans('order.edit') : trans('order.add')}} </h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="panel">
                                <div class="panel-body pn">
                                    <div class="table-responsive">
                                        @if(Session::has('flash_message'))
                                            <div class="alert alert-success">
                                                {{Session::get('flash_message')}}
                                            </div>
                                        @endif
                                        {!! Form::open(['class' => 'form-validate-recrui', 'id' => 'dsungvien' , 'files'=> true , 'enctype' => 'multipart/from-data' ]) !!}
                                            @include('CategoryManager::order.form')
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('script')
    <script>
        function getAjaxSelect(id , str , css ){
            // var id  = $(this).val();
            var url = '{!! asset('ajax/select') !!}' + '-' + str;

            $.get( url, { id: id } )
                .done(function( data ) {
                    if(data){
                        if(str == 'loai'){
                            $('.loai').html(data.html_type);
                            $('.bo-phan').html(data.html_part);
                        }else{
                            $('.' + css ).html(data);
                        }
                    }
                });
        }

        $( document ).ready(function() {
            $('.amount, .price').number(true);

            $( ".purchase_date" ).datepicker({
                prevText: '<i class="fa fa-chevron-left"></i>',
                    nextText: '<i class="fa fa-chevron-right"></i>',
                    showButtonPanel: false,
                    dateFormat: "dd/mm/yy",
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '1970:{!! Carbon\Carbon::today()->format('Y') !!}',
            });

            $('.dm').on('change', function () {
                var id  = $(this).val();
                var str ='loai';
                getAjaxSelect(id , str , str );
            });

            $('.ldm').on('change', function () {
                var id  = $(this).val();
                var str = 'bo-phan';
                getAjaxSelect(id , str , str );
            });


        });
    </script>
@endsection