@extends('admin.layouts.app')

@section('title', 'Add University')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add University</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add New University</h3>
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
                    {{ Form::open(['url' => '/admin/save-college', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
                    {{csrf_field()}}
                    <div class="box-body">
                        <!--Basic Info Start-->
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                <h4>Basic Information :-</h4>
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('collageType', 'University Type') }}<span class="required">*</span>
                                {{ Form::select('collage_type', @$collageType,'',['class' => 'form-control chosen-select'])}}

                            </div>
                            
                            <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Name of University') }}<span class="required">*</span>
                                {{ Form::text('name', null, ['placeholder' => 'Name of Institute', 'class' => 'form-control title','required'=>'required']) }}
                            </div>
                             <div class="col-md-6 form-group">
                                {{ Form::label('Slug', 'Slug') }}<span class="required">*</span>
                                {{ Form::text('slug', null, ['placeholder' => 'Slug', 'class' => 'form-control slug','required'=>'required']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Website', 'Website') }}<span class="required">*</span>
                                {{ Form::text('website', null, ['placeholder' => 'Website', 'class' => 'form-control','required'=>'required']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Email Id', 'Email Id') }}<span class="required">*</span>
                                {{ Form::email('email', null, ['placeholder' => 'Email Id', 'class' => 'form-control','required'=>'required']) }}
                            </div>

                            <div class="col-md-6 form-group">
                                {{ Form::label('Mobile No', 'Mobile No.') }}
                                {{ Form::text('mobile_no', null, ['placeholder' => 'Mobile Number', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Landline No.', 'Landline No') }}
                                {{ Form::text('landline_no', null, ['placeholder' => 'Landline Number', 'class' => 'form-control']) }}
                            </div>
                            <div class=" col-md-6 form-group">
                                {{ Form::label('Alternative No.', 'Alternative No') }}
                                {{ Form::text('alternative_no', null, ['placeholder' => 'Alternative Number', 'class' => 'form-control']) }}
                            </div>
                           

                            <div class="col-md-12 form-group">
                                {{ Form::label('Addresss', 'Address') }}<span class="required">*</span>
                                {{Form::textarea('address',null,['class'=>'form-control', 'rows' => 8, 'cols' => 40])}}
                            </div>

                        </div>
                        <!--Basic Info End-->

                        <!--About Institute Start-->
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                <h4>About University :-</h4>
                            </div>


                            <div class="col-md-6 form-group">
                                {{ Form::label('Logo.', 'Logo') }}                               
                                <input type="file" name="logo" class="form-control">
                                <input type="hidden" name="usertype" value="<?php echo Config::get('constants.UniversityType')?>">
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Cover Image.', 'Cover Image') }}
                                <input type="file" name="cover_img" class="form-control">
                            </div>



                            <div class="col-md-12 form-group">
                                {{ Form::label('About the University', 'About the University') }}
                                {{Form::textarea('about',null,['class'=>'form-control', 'rows' => 8, 'cols' => 40])}}
                            </div>

                        </div>

                        <!--About Institute End-->

                        <!--Popular Alumni Start-->
                        <div class="row">
                            <div class="col-md-12 form-group">

                                <h4>Message from Head of Institute :-</h4>
                                <input type="file" name="head_inst_img" class="form-control">
                          
                                {{Form::textarea('head_inst_msg',null,['class'=>'form-control','placeholder'=>'Please Input some Message here' ,'rows' => 5, 'cols' => 40])}}



                            </div>
                        </div>
                        <!--Popular Alumni End-->


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




