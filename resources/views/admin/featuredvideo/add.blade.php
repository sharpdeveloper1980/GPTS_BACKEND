@extends('admin.layouts.app')

@section('title', 'Add Featured Video')

@section('content')

@include('admin.layouts.header')
<style>
    select.selectpicker { display:none; /* Prevent FOUC */}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add Featured Video</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Featured Video</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/featuredvideolist'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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

                    {{ Form::open(['url' => '/admin/save-featured-video', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
                    {{csrf_field()}}

                    <div class="box-body">
                        <div class="row form-group">


                            <div class="col-md-12 form-group">
                                {{ Form::label('name', 'Title') }}<span class="required">*</span>
                                <?php
                                $sessionlist = array(
                                    "" => "Select",
                                    "GREAT INDIAN SCHOOLS"           => "GREAT INDIAN SCHOOLS",
                                    "GREAT INDIAN INSTITUTES"        => "GREAT INDIAN INSTITUTES",
                                    "EDUCATION EVANGELIST OF INDIA"   => "EDUCATION EVANGELIST OF INDIA"
                                );
                                ?>
                                {{ Form::select('title',@$sessionlist ,'', ['class' => 'form-control','required'=>'required']) }}
                            </div>
                            <!--                            <div class="col-md-12 form-group">
                                                            {{ Form::label('name', 'Episode') }}<span class="required">*</span>
                            <?php
                            $eplist = array();
                            for ($i = 1; $i <= 15; $i++) {
                                $eplist[$i . ' Episode'] = $i . ' Episode';
                            }
                            ?>
                                                             {{ Form::select('episode',@$eplist ,'', ['class' => 'form-control','required'=>'required']) }}
                                                        </div>-->
                            <div class="col-md-12 form-group">
                                {{ Form::label('name', 'Institution/School Name') }}<span class="required">*</span>
                                {{ Form::text('name',null, ['placeholder' => 'Institution/School Name', 'class' => 'form-control ','required'=>'required']) }}
                            </div>
                            <div class="col-md-12 form-group">
                                {{ Form::label('name', 'Location Name') }}
                                {{ Form::text('location',null, ['placeholder' => 'Location Name', 'class' => 'form-control ']) }}
                            </div>
                            <div class="col-md-12 form-group">
                                {{ Form::label('Video Thumbnail', 'Video Thumbnail') }}<span class="required">*</span>
                                <input type="file" name="video_thumb" required class="form-control imagefl">

                            </div>
                            <div class="col-md-12 form-group">
                                {{ Form::label('Video Link', 'Video Link') }}<span class="required">*</span>
                                {{ Form::text('video_link', null, ['placeholder' => 'Video Link', 'class' => 'form-control ','required'=>'required']) }}
                            </div>

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




