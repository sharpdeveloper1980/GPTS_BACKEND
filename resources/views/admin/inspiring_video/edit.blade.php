@extends('admin.layouts.app')

@section('title', 'Edit Inspiring Video')

@section('content')

@include('admin.layouts.header')
<style>
    select.selectpicker { display:none; /* Prevent FOUC */}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Inspiring Video</h1>
    </section>
    <section class="content">   
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Inspiring Video</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/inspiringvideo'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
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

                    {{ Form::model($inspringvideo, ['method' => 'post','url' => ['/admin/edit-inspiring-video', @$inspringvideo->id] ,'files' => true]) }}
                    {{csrf_field()}}

                    <div class="box-body">
                        <div class="row form-group">
                            
                            <div class="col-md-4 form-group">
                                {{ Form::label('title', 'Title') }}<span class="required">*</span>
                                {{ Form::text('title',@$inspringvideo->title , ['placeholder' => 'Video Title', 'class' => 'form-control ','required'=>'required']) }}
                            </div>

                            <div class="col-md-4 form-group">
                                {{ Form::label('name', 'Name') }}<span class="required">*</span>
                                {{ Form::text('name', @$inspringvideo->name, ['placeholder' => 'Video Name', 'class' => 'form-control ','required'=>'required']) }}
                            </div>
                             <div class="col-md-4 form-group">
                                {{ Form::label('designation', 'Designation') }}<span class="required">*</span>
                                {{ Form::text('designation', @$inspringvideo->designation, ['placeholder' => 'Designation', 'class' => 'form-control ','required'=>'required']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                 {{ Form::label('Video Thumbnail', 'Video Thumbnail') }}<span class="required">*</span>
                                @if($inspringvideo->video_thumb!=null || $inspringvideo->video_thumb!='')                                                                
                                <div class="bg_img" style="background:url(https://s3.eu-west-1.amazonaws.com/gpts-portal/inspiring/image/{{$inspringvideo->video_thumb}})"></div>
                                @endif
                                <input type="file" name="video_thumb" class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Video') }}<span class="required">*</span>
                                @if($inspringvideo->video!=null || $inspringvideo->video!='')
                                <video width="500" height="250" controls><source src="https://s3.eu-west-1.amazonaws.com/gpts-portal/inspiring/video/{{$inspringvideo->video}}" type="video/mp4"></video>
                                @endif
                                <input type="file" name="video" class="form-control">
                                
                            </div>
                            <div class="col-md-2 form-group">
                                {{ Form::label('Position', 'Position') }}
                                {{ Form::number('position',@$inspringvideo->position, ['placeholder' => 'Position', 'class' => 'form-control']) }}
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




