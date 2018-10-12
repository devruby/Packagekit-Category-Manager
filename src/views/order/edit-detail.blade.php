@extends('hrms.layouts.base')
@section('title', $data->title)
@section('content')
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />--}}
    <!-- START CONTENT -->
    <div class="content">
        <!-- -------------- Content -------------- -->
        <section id="content" class="animated fadeIn">
            <!-- -------------- Column Center -------------- -->
            <div class="row ">
                <div class="col-xs-12">
                    <div class="box-title">
                        <h3><i class="fa fa-user" aria-hidden="true"></i> {{ isset($data->list) && $data->list ? trans('order.edit-detail') : trans('order.add')}} </h3>
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
                                        @include('CategoryManager::order.form-detail')
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
        $(document).ready(function() {
            $('.select2-single').select2();
        });
    </script>
@endsection