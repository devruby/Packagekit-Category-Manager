@extends('CategoryManager::layouts.base')
@section('title', $title)
@section('content')
    <style>
        #content .panel {
            box-shadow: none;
        }
        .full-width{
            width: 100%;
        }
    </style>

    <section id="content" class="animated fadeIn">
        <div class="mw1000 center-block">
            <div class="row">
                <div class="col-xs-5">
                    <div class="box-title" >
                        <h3><i class="fa fa-globe" aria-hidden="true"></i> {{$title}} </h3>
                    </div>
                </div>
            </div>

            <div class="box box-success">
                <div class="panel">
                    <div class="row allcp-form">
                        {!! Form::open(array('TaxonomyController@getAddCategory', $slug)) !!}
                            @if($slug == 'danh-muc')
                                @include('hrms.taxonomy.form_dm')
                            @elseif($slug == 'loai')
                                @include('hrms.taxonomy.form_l')
                            @elseif($slug == 'bo-phan')
                                @include('hrms.taxonomy.form_bp')
                            @endif

                            <div class="row">
                                <div class="col-md-2">
                                    <input type="submit" class="btn btn-primary btn-add" value="{!! isset($data) ?  trans('taxonomy.save') :  trans('taxonomy.add_new') !!}">
                                </div>
                                <div class="col-md-2">
                                    <a  class="btn btn-danger btn-add full-width" href="{!! asset('taxonomy/list-category/' . (isset($data->taxonomy_type) && $data->taxonomy_type ? $data->taxonomy_type : $slug )) !!}">
                                        {!! trans('hrm.cancel') !!}
                                    </a>
                                </div>
                            </div>
                        {{ Form::close() }}
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

@section('script')
    <script>
        $( document ).ready(function() {
            $('.dm').on('change', function () {
                var id = $(this).val();
                var select = $(this);
                console.log(id);
                var url = '{!! asset('ajax/select-loai') !!}';
                $.get( url, { id: id } )
                    .done(function( data ) {
                        $('.loai').html(data);
                    });
            })
        });
    </script>
@endsection