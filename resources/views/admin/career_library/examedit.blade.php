@extends('admin.layouts.app')

@section('title', 'Edit Entrance Examination')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{@$careername->name}} Entrance Examination</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Entrance Examination</h3>
                        <div class="pull-right">

                            <button type="button" class="btn btn-success " onclick="addmore()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-danger " onclick="remove()"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            <a href="{!! url('/admin/edit-sub-career'); !!}/{{@$subcareer_id}}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
                    {{ Form::open(['url' => '/admin/edit-career-exam', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
                    {{csrf_field()}}
                    <div class="box-body">

                        <div class=" form-group gallerylist">
                            <input type="hidden" name="page" class="page" value="1">
                            <input type="hidden" name="career_id" value="{{@$career_id}}">
                            <div class="col-md-12">

                            </div>
                            @if($careerexam->count() > 0)
                            @foreach($careerexam as $index => $value)
                            <div class="gall borderbox">
                                <div class="col-md-6 form-group">
                                    {{ Form::label('name', 'Name') }}<span class="required">*</span>
                                    {{ Form::text('name[]', @$value->name, ['placeholder' => 'Name', 'class' => 'form-control','required'=>'required']) }}

                                </div>

                                <div class="col-md-6 form-group">
                                    {{ Form::label('logo', 'Logo') }}
                                    @if(isset($value->logo) && $value->logo!='')
                                    <a href="{{URL::asset("/public/image/career_exam/logo/".$value->logo)}}" target="blank" >View</a>

                                    <input type="hidden" name="examlogo[]" value="{{$value->logo}}">
                                    @else

                                    <input type="hidden" name="examlogo[]" value="">
                                    @endif

                                    <input type="file" name="logo[]" class="form-control imagefl">    
                                </div>
                                <div class="col-md-12 form-group">
                                    {{ Form::label('name', 'Details(Eligibility,ProgramDetails,qualifications)') }}
                                    {{ Form::textarea('details[]', @$value->details, ['placeholder' => 'Details', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('name', 'Syllabus') }}
                                    @if(isset($value->syllabus) && $value->syllabus!='')
                                    <a href="{{URL::asset("/public/image/career_exam/syllabus/".$value->syllabus)}}" target="blank">View</a>  
                                    <input type="hidden" name="syllb[]" value="{{$value->syllabus}}">
                                    @else
                                    <input type="hidden" name="syllb[]" value="">
                                    @endif
                                    <input type="file" name="syllabus[]" class="form-control doctype">


                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('name', 'Date of Exam') }}
                                    {{ Form::date('date_of_exam[]', @$value->exam_date, ['placeholder' => 'Date of Exam', 'class' => 'form-control']) }}

                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('name', 'Application Form Download') }}
                                    @if(isset($value->application_form) && $value->application_form!='')
                                    <a href="{{URL::asset("/public/image/career_exam/document/".$value->application_form)}}" target="blank">View</a>  
                                    <input type="hidden" name="applidoc[]" value="{{$value->application_form}}">
                                    @else

                                    <input type="hidden" name="applidoc[]" value="">
                                    @endif
                                    <input type="file" name="application_form[]" class="form-control doctype">

                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('name', 'Appilication Fee') }}
                                    {{ Form::text('application_fee[]', @$value->application_fee, ['placeholder' => 'Appilication Fee', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('Examination For', 'Examination For') }}<span class="required">*</span>
                                    {{ Form::select('exam_for[]', $examfor,@$value->exam_for,['class' => 'form-control'])}}

                                </div>

                            </div>
                            @endForeach
                            @else
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
                            @endif
                            <div id="gallery">

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




