@extends('admin.layouts.app')

@section('title', 'Add Career Video Library')

@section('content')

@include('admin.layouts.header')
<style>
    select.selectpicker { display:none; /* Prevent FOUC */}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add Career Video Library</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Career Video Library</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/show-career-video'); !!}/<?php echo $_GET['career_id'] ?>/{{$subcareer_id}}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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

                    {{ Form::open(['url' => '/admin/save-career-video', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
                    {{csrf_field()}}

                    <div class="box-body">
                        <div class="row form-group">
                           <input type="hidden" name="career_id" value="<?php echo $_GET['career_id'] ?>">
                            <div class="col-md-6 form-group">
                                {{ Form::label('Video Type', 'Video Type') }}<span class="required">*</span>
                                {{ Form::select('type', @$videotype,'',['class' => 'form-control'])}}

                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', 'Title') }}<span class="required">*</span>
                                {{ Form::text('title', (\Session::get('error'))?\Session::get('oldtitle'):null, ['placeholder' => 'Video Title', 'class' => 'form-control ','required'=>'required']) }}
                            </div>
                            
                            <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Name') }}<span class="required">*</span>
                                {{ Form::text('name',(\Session::get('error'))?\Session::get('oldname'):null, ['placeholder' => 'Video Name', 'class' => 'form-control ','required'=>'required']) }}
                            </div>
                           <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Designation') }}<span class="required">*</span>
                                {{ Form::text('designation',null, ['placeholder' => 'Designation', 'class' => 'form-control ','required'=>'required']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Video Thumbnail', 'Video Thumbnail') }}<span class="required">*</span>
                                <input type="file" name="video_thumb" required class="form-control imagefl">

                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Video') }}<span class="required">*</span>
                                <input type="file" name="video" required class="form-control" id="fl">

                            </div>
                           

                            <div class="col-md-12 form-group">
                                {{ Form::label('about', 'Breif Description') }}<span class="required">*</span>
                                {{Form::textarea('about',null,['class'=>'form-control', 'rows' => 4, 'cols' => 50, 'required'=>'required'])}}
                            </div>

                            <!--<div class="col-md-2 form-group">
                                {{ Form::label('Position', 'Position') }}<span class="required">*</span>
                                {{ Form::number('position',null, ['placeholder' => 'Position', 'class' => 'form-control ','required'=>'required']) }}
                            </div>-->
                        

                        </div>
                      
                        <div class="col-md-12">
                            <div class="box-footer text-right">
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




