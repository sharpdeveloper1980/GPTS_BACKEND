@extends('admin.layouts.app')

@section('title', 'Edit School')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit School</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit School</h3>
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
                    {{ Form::model($school, ['method' => 'post','url' => ['/admin/edit-school', @$school->id] ,'files' => true]) }}
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row form-group gallerylist">

                                <div>
                                    <div class="col-md-6 form-group ">
                                        {{ Form::label('name', 'School Name') }}<span class="required">*</span>
                                        {{ Form::text('name', @$school->name, ['placeholder' => 'Name', 'class' => 'form-control','required'=>'required']) }}
                                    </div>
                                    <div class="col-md-6 form-group">
                                        {{ Form::label('college', 'School Type') }}<span class="required">*</span>
                                        {{ Form::select('school_type', @$schooltype,@$school['SchoolDetail']->school_type,['class' => 'form-control'])}}

                                    </div>
                                
                                <div class="col-md-12 form-group ">
                                    {{ Form::label('Address', 'Address') }}
                                    {{Form::textarea('address',@$school['SchoolDetail']->addess,['class'=>'form-control','placeholder' => 'Address', 'rows' => 8, 'cols' => 40])}}
                                </div>
                                <div class="col-md-6 form-group ">
                                    {{ Form::label('name', 'Email Id') }}<span class="required">*</span>
                                    {{ Form::email('email', @$school->email, ['placeholder' => 'Email Id', 'class' => 'form-control','required'=>'required']) }}
                                </div>
                                <div class="col-md-6 form-group ">
                                    {{ Form::label('name', 'Contact No.') }}
                                    {{ Form::text('contact', @$school->contact, ['placeholder' => 'Contact No', 'class' => 'form-control','maxlength'=>'10','minlength'=>'10','pattern'=>'\d*']) }}
                                </div>
                                    </div>
                            <div>
                                <div class="col-md-12 form-group">
                                    <h4>In Management :-</h4>
                                </div>
                            <div class="col-md-6 form-group ">
                                    {{ Form::label('name', 'Management Name') }}
                                    {{ Form::text('management_name', @$school['SchoolDetail']->management_name, ['placeholder' => 'Management name', 'class' => 'form-control']) }}
                                </div>
                            <div class="col-md-6 form-group ">
                                    {{ Form::label('name', 'Management Email Id') }}
                                    {{ Form::email('management_email', @$school['SchoolDetail']->management_email, ['placeholder' => 'Management email id', 'class' => 'form-control']) }}
                                </div>
                            <div class="col-md-6 form-group ">
                                    {{ Form::label('name', 'Management Designation') }}
                                    {{ Form::text('management_designation', @$school['SchoolDetail']->management_designation, ['placeholder' => 'Designation', 'class' => 'form-control']) }}
                                </div>
                                
                            </div>
                             <div>
                                <div class="col-md-12 form-group">
                                    <h4>Contact Person :-</h4>
                                </div>
                            <div class="col-md-6 form-group ">
                                    {{ Form::label('name', 'Contact Person Name') }}
                                    {{ Form::text('contact_pre_name', @$school['SchoolDetail']->contact_pre_name, ['placeholder' => 'Contact Person Name', 'class' => 'form-control']) }}
                                </div>
                            <div class="col-md-6 form-group ">
                                    {{ Form::label('name', 'Contact Person No.') }}
                                    {{ Form::text('contact_pre_phn_no', @$school['SchoolDetail']->contact_pre_phn_no, ['placeholder' => 'Contact Person No', 'class' => 'form-control','maxlength'=>'10','minlength'=>'10','pattern'=>'\d*']) }}
                                </div>
                            <div class="col-md-6 form-group ">
                                    {{ Form::label('name', 'Contact Person Email Id') }}
                                    {{ Form::email('contact_pre_email', @$school['SchoolDetail']->contact_pre_email, ['placeholder' => 'Contact Person Email Id', 'class' => 'form-control']) }}
                                </div>
                                
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




