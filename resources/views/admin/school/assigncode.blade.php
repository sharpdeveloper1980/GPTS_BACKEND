@extends('admin.layouts.app')

@section('title', 'Add School')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Assign School</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Assign School</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/school-list'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
                    {{ Form::open(['url' => '/admin/save-assign-code', 'method' => 'get', 'enctype'=>'multipart/form-data']) }}
                    {{csrf_field()}}
                    <div class="box-body">
                       
                        <div class="row form-group gallerylist">

                                    <!--<div class="col-md-6 form-group ">
                                        {{ Form::label('name', 'School Name') }}<span class="required">*</span>
                                        {{ Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control','required'=>'required']) }}
                                    </div>-->
                                    <div class="col-md-6 form-group">
                                        {{ Form::label('college', 'GPTS registered Schools') }}<span class="required">*</span>
                                        <select required name="school" id="school" class="form-control">
                                        <option value="">Select School</option>
                                        @foreach($schools as $key)
                                            <option value="{{$key->id}}">{{$key->name}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group ">
                                        {{ Form::label('number', 'No of Licence') }}<span class="required">*</span>
                                        {{ Form::number('number', null, ['placeholder' => 'No of Licence', 'class' => 'form-control','required'=>'required']) }}
                                    </div>
                                
                        <div class="col-md-12">
                            <div class="box-footer text-right">
                                {{ Form::submit('Assign Code', ['class' => 'btn btn-warning']) }}
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

<div class="gallery_img hidden ">
    <div class="col-md-12 form-group gall">
        {{ Form::text('name[]', null, ['placeholder' => 'Course Name','onblur'=>'getCourseName()', 'class' => 'form-control gall','required'=>'required']) }}
    </div>
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




