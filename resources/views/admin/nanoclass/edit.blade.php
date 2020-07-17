@extends('admin.layouts.app')

@section('title', 'Edit Nano Class')

@section('content')

@include('admin.layouts.header')
<style>
    select.selectpicker { display:none; /* Prevent FOUC */}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Nano Class ({{$collegeName}})</h1>
    </section>
    <section class="content">   
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="pull-right">
                            <a href="{!! url('/admin/nano-class-video-list'); !!}/{{$nanoclass->college_id}}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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

                    {{ Form::model($nanoclass, ['method' => 'post','url' => ['/admin/update-nano-class', @$nanoclass->id] ,'files' => true]) }}
                    {{csrf_field()}}

                    <div class="box-body">
                        <div class="row form-group">
     
                            <div class="col-md-4 form-group">
                                {{ Form::label('title', 'Title') }}<span class="required">*</span>
                                {{ Form::text('title', $nanoclass->title, ['placeholder' => 'Video Title', 'class' => 'form-control','required'=>'required']) }}
                            </div>
                    

                            <div class="col-md-4 form-group">
                                {{ Form::label('Video Thumbnail', 'Video Thumbnail') }}
                                <input type="file" name="video_thumb" class="form-control">
                                @if($nanoclass->video_thumb!=null || $nanoclass->video_thumb!='')                                                                
                                <div class="bg_img" style="background:url(https://s3.eu-west-1.amazonaws.com/gpts-portal/nanoclass/thumb/{{$nanoclass->video_thumb}})">
                                </div>
                                @endif
                            </div>
                           

                            <div class="col-md-4 form-group">
                                {{ Form::label('name', 'Video') }}
                                <input type="file" name="video" class="form-control">
                                @if($nanoclass->video!=null || $nanoclass->video!='')
                                <video width="300" height="200" controls><source src="https://s3.eu-west-1.amazonaws.com/gpts-portal/nanoclass/video/{{$nanoclass->video}}" type="video/mp4"></video>
                                @endif
                            </div>

                            <div class="col-md-12 form-group">
                                {{ Form::label('descp', 'Description') }}<span class="required">*</span>
                                <textarea required class="form-control" name="descp">{{$nanoclass->descp}}</textarea>
                            </div>

                        </div>
                      
                        <div class="col-md-12">
                            <div class="box-footer text-right">
                                {{ Form::submit('Update', ['class' => 'btn btn-warning']) }}
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




