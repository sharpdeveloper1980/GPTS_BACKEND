@extends('admin.layouts.app')

@section('title', 'Career Entrance Examination')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Career Entrance Examination</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Career Entrance Examination</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/edit-sub-career'); !!}/{{@$subcareer_id}}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
                            <button type="button" class="btn btn-success " onclick="addmore()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-danger " onclick="remove()"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
                    {{ Form::open(['url' => '/admin/save-career-exam', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
                    {{csrf_field()}}
                    <div class="box-body">
                        <input type="hidden" name="career_id" value="<?php echo $_GET['career_id'] ?>">
                        <div class=" form-group gallerylist">
                            <div class="col-md-12 form-group">
                                <h4>
                                </h4>
                            </div>
                            <div class="gall borderbox">
                                <div class="col-md-6 form-group">
                                    {{ Form::label('name', 'Name') }}<span class="required">*</span>
                                    {{ Form::text('name[]', null, ['placeholder' => 'Name', 'class' => 'form-control','required'=>'required']) }}
                                </div>

                                <div class="col-md-6 form-group">
                                    {{ Form::label('logo', 'Logo') }}
                                    <input type="hidden" name="examlogo[]" value="">
                                    <input type="file" name="logo[]" class="form-control imagefl">

                                </div>
                                <div class="col-md-12 form-group">
                                    {{ Form::label('name', 'Details(Eligibility,ProgramDetails,qualifications)') }}
                                    {{ Form::textarea('details[]', null, ['placeholder' => 'Details', 'class' => 'form-control']) }}

                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('name', 'Syllabus') }}
                                    <input type="hidden" name="syllb[]" value="">
                                    <input type="file" name="syllabus[]" class="form-control doctype">

                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('name', 'Date of Exam') }}
                                    {{ Form::date('date_of_exam[]', null, ['placeholder' => 'Date of Exam', 'class' => 'form-control']) }}

                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('name', 'Application Form Download') }}
                                    <input type="hidden" name="applidoc[]" value="">
                                    <input type="file" name="application_form[]" class="form-control doctype">

                                </div>

                                <div class="col-md-6 form-group">
                                    {{ Form::label('name', 'Appilication Fee') }}
                                    {{ Form::text('application_fee[]', null, ['placeholder' => 'Appilication Fee', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('Examination For', 'Examination For') }}<span class="required">*</span>
                                    {{ Form::select('exam_for[]', $examfor,'',['class' => 'form-control'])}}

                                </div>
                                <input type="hidden" name="page" class="page" value="1">
                            </div>
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
    <div class="gall borderbox">
        <div class="col-md-6 form-group">
            {{ Form::label('name', 'Name') }}<span class="required">*</span>
            {{ Form::text('name[]', null, ['placeholder' => 'Name', 'class' => 'form-control','required'=>'required']) }}
        </div>
        <div class="col-md-6 form-group">
            {{ Form::label('logo', 'Logo') }}
            <input type="hidden" name="examlogo[]" value="">
            <input type="file" name="logo[]" class="form-control imagefl">

        </div>
        <div class="col-md-12 form-group">
            {{ Form::label('name', 'Details(Eligibility,ProgramDetails,qualifications)') }}
            {{ Form::textarea('details[]', null, ['placeholder' => 'Details', 'class' => 'form-control']) }}

        </div>
        <div class="col-md-4 form-group">
            {{ Form::label('name', 'Syllabus') }}
            <input type="hidden" name="syllb[]" value="">
            <input type="file" name="syllabus[]" class="form-control doctype">

        </div>
        <div class="col-md-4 form-group">
            {{ Form::label('name', 'Date of Exam') }}
            {{ Form::date('date_of_exam[]', null, ['placeholder' => 'Date of Exam', 'class' => 'form-control']) }}

        </div>
        <div class="col-md-4 form-group">
            {{ Form::label('name', 'Application Form Download') }}
            <input type="hidden" name="applidoc[]" value="">
            <input type="file" name="application_form[]" class="form-control doctype">

        </div>

        <div class="col-md-6 form-group">
            {{ Form::label('name', 'Appilication Fee') }}
            {{ Form::text('application_fee[]', null, ['placeholder' => 'Appilication Fee', 'class' => 'form-control']) }}
        </div>
        <div class="col-md-6 form-group">
            {{ Form::label('Examination For', 'Examination For') }}<span class="required">*</span>
            {{ Form::select('exam_for[]', $examfor,'',['class' => 'form-control'])}}

        </div>
    </div>
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




