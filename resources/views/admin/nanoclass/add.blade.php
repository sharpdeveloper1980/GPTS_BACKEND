@extends('admin.layouts.app')

@section('title', 'Add Nano Class Video')

@section('content')

@include('admin.layouts.header')
<style>
    select.selectpicker { display:none; /* Prevent FOUC */}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add Nano Class Video ({{$collegeName}})</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <!--<h3 class="box-title">Add Nano Class Video ({{$collegeName}})</h3>-->
                        <div class="pull-right">
                            <a href="{!! url('/admin/nano-class-video-list'); !!}/{{$cid}}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    @if (\Session::get('error'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach (\Session::get('error') as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if (\Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ \Session::get('success') }}</p>
                    </div>
                    @endif

                    {{ Form::open(['url' => '/admin/save-nano-video', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
                    {{csrf_field()}}

                    <div class="box-body">
                        <div class="row form-group">
     
                            <div class="col-md-4 form-group">
                                {{ Form::label('title', 'Title') }}<span class="required">*</span>
                                {{ Form::text('title', null, ['placeholder' => 'Video Title', 'class' => 'form-control','required'=>'required']) }}
                            </div>
                          
                            <div class="col-md-4 form-group">
                                {{ Form::label('Video Thumbnail', 'Video Thumbnail') }}<span class="required">*</span>
                                <input type="file" name="video_thumb" required class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                {{ Form::label('name', 'Video') }}<span class="required">*</span>
                                <input type="file" name="video" required class="form-control">
                            </div>

                            <div class="col-md-12 form-group">
                                {{ Form::label('descp', 'Description') }}<span class="required">*</span>
                                <textarea required class="form-control" name="descp"></textarea>
                            </div>

                        </div>
                      
                        <div class="col-md-12">
                            <div class="box-footer text-right">
                                <input type="hidden" name="college" value="{{$cid}}"/>
                                {{ Form::submit('Add New', ['class' => 'btn btn-warning']) }}
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
                <!-- /.box --> 
            </div>
        </div>
    </section> 
</div>

<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection
<script>
    function checkType(val){
       if(val == 'country' || val == 'college'){
            $("#logoinput").show();
       }else{
            $("#logoinput").hide();
       }
    }
</script>
    
    
    