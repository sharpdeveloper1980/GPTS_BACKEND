@extends('admin.layouts.app')

@section('title', 'Add Collage')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>College Gallery</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add college Gallery</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/college-list'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
                    {{ Form::open(['url' => '/admin/save-gallery', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                {{ Form::label('college', 'College') }}<span class="required">*</span>
                                {{ Form::select('college_id', @$college,'',['class' => 'form-control chosen-select'])}}

                            </div>
                        </div>
                        <div class="row form-group gallerylist">
                            <div class="col-md-12 form-group">
                                <h4>Gallery :- <button type="button" class="btn btn-success pull-right" onclick="addmore()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    <button type="button" class="btn btn-danger pull-right" onclick="remove()"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </h4>
                            </div>
                            <div class="col-md-3 form-group gall_1">
                                <input type="file" name="gallery_img[]" class="form-control" required> 
                            </div>
                            <div class="col-md-3 form-group gall_2">
                                <input type="file" name="gallery_img[]" class="form-control" required> 
                            </div>
                            <div class="col-md-3 form-group gall_3">
                                <input type="file" name="gallery_img[]" class="form-control"> 
                            </div>
                            <div class="col-md-3 form-group gall_4">
                                <input type="file" name="gallery_img[]" class="form-control"> 
                            </div>
                            <input type="hidden" name="page" class="page" value="4">
                            <div id="gallery">

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
<div class="gallery_img hidden">
    <div class="col-md-3 gall form-group">
        <input type="file" name="gallery_img[]" class="form-control">
    </div>
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




