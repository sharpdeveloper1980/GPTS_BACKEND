@extends('admin.layouts.app')

@section('title', 'Add Team')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>College Courses</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Team</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/team-list'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
                    {{ Form::open(['url' => '/admin/save-team', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row form-group">
                            <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Name') }}<span class="required">*</span>
                                {{ Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control title','required'=>'required']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Designation') }}<span class="required">*</span>
                                {{ Form::text('designation', null, ['placeholder' => 'Name', 'class' => 'form-control','required'=>'required']) }}
                            </div>

                            <div class="col-md-6 form-group">
                                {{ Form::label('type', 'Type') }}<span class="required">*</span>
                                {{ Form::select('type', @$typelist,'',['class' => 'form-control chosen-select'])}}
                            </div>
                            <div class="col-md-12 form-group">
                                {{ Form::label('name', 'Image') }}<span class="required">*</span>
                                <input type="file" name="image" required class="form-control">
                            </div>   

                            <div class="col-md-12 form-group">
                                {{ Form::label('Addresss', 'Brief Description') }}<span class="required">*</span>
                                {{Form::textarea('description',null,['class'=>'form-control', 'rows' => 8, 'cols' => 40])}}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Linkedin') }}
                                {{ Form::text('linkedin', null, ['placeholder' => 'Linkedin', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Twitter') }}
                            {{ Form::text('twitter', null, ['placeholder' => 'Twitter', 'class' => 'form-control']) }}
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




