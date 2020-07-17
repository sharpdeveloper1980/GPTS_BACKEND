@extends('admin.layouts.app')

@section('title', 'Edit Home Video')

@section('content')

@include('admin.layouts.header')
<style>
    select.selectpicker { display:none; /* Prevent FOUC */}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Static Page Video</h1>
    </section>
    <section class="content">   
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Static Page Video</h3>
                       <div class="pull-right">
                            <a href="{!! url('/admin/static-page-video-list'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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

                    {{ Form::model($videolist, ['method' => 'post','url' => ['/admin/edit-home-video', @$videolist->id] ,'files' => true]) }}
                    {{csrf_field()}}

                    <div class="box-body">
                        <div class="row form-group">
                            
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', 'Title') }}<span class="required">*</span>
                                {{ Form::text('title',@$videolist->title , ['placeholder' => 'Video Title', 'class' => 'form-control ','required'=>'required']) }}
                            </div>
                            
                            <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Name') }}<span class="required">*</span>
                                {{ Form::text('name', @$videolist->name, ['placeholder' => 'Video Name', 'class' => 'form-control ','required'=>'required']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                 {{ Form::label('Video Thumbnail', 'Video Thumbnail') }}<span class="required">*</span>
                                @if($videolist->video_thumb!=null || $videolist->video_thumb!='')                                                                
                                <div class="bg_img" style="background:url(https://s3.eu-west-1.amazonaws.com/gpts-portal/home-video/{{$videolist->video_thumb}})"></div>
                                @endif
                                <input type="file" name="video_thumb" class="form-control imagefl">                                
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Video', 'Video') }}<span class="required">*</span>
                                @if($videolist->video!=null || $videolist->video!='')
                                <video width="500" height="250" controls><source src="https://s3.eu-west-1.amazonaws.com/gpts-portal/home-video/{{$videolist->video}}" type="video/mp4"></video>
                                @endif
                                <input type="file" name="video" class="form-control" id="fl">                            
                            </div>
                           <!-- <div class="col-md-12 form-group">
                                {{ Form::label('description', 'Description') }}<span class="required">*</span>
                                {{ Form::textarea('description', @$videolist->description, ['placeholder' => 'Description', 'class' => 'form-control']) }}
                            </div>-->
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




