@extends('admin.layouts.app')

@section('title', 'Add Scholarship')

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
                        <h3 class="box-title">Add college courses</h3>
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
                    {{ Form::open(['url' => '/admin/save-course', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                {{ Form::label('college', 'College') }}<span class="required">*</span>
                                {{ Form::select('college_id', @$college,'',['class' => 'form-control chosen-select ','onchange'=>'getCourseName()','id'=>'college_id'])}}

                            </div>
                        </div>
                        <div class="row form-group gallerylist">
                            <!--<div class="col-md-12 form-group">
                                <h4><button type="button" class="btn btn-success pull-right" onclick="addmore()"><i class="fa fa-plus" aria-hidden="true"></i></button>

                                </h4>
                            </div>-->
                            <div class="gall">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <div class="col-md-8">
                                            {{ Form::label('name', 'Course Name') }}<span class="required">*</span>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-success pull-right" onclick="addmore()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            <button type="button" class="btn btn-danger pull-right" onclick="remove()"><i class="fa fa-trash" aria-hidden="true"></i></button> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group ">

                                    {{ Form::text('name[]', null, ['placeholder' => 'Course Name','onblur'=>'getCourseName()', 'class' => 'form-control gall_1','required'=>'required']) }}
                                    
                                </div>
                                <div id="gallery">

                                </div> 
                                <div class="col-md-12 form-group ">
                                    {{ Form::label('name', 'About Course') }}
                                    <input type="hidden" name="page" class="page" value="1">
                                    {{Form::textarea('about',null,['class'=>'form-control','placeholder' => 'Enter about course', 'rows' => 8, 'cols' => 40])}}
                                </div>
                                <div class="col-md-6 form-group ">
                                    {{ Form::label('name', 'Admission System') }}
                                    {{ Form::text('admission_system', null, ['placeholder' => 'Admission System', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-6 form-group ">
                                    {{ Form::label('name', 'Duration') }}
                                    {{ Form::text('duration', null, ['placeholder' => 'Duration', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-12 form-group ">
                                    {{ Form::label('name', 'Eligibility Criteria') }}
                                    {{ Form::text('eligibility_criteria', null, ['placeholder' => 'Eligibility Criteria', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4 form-group ">
                                    {{ Form::label('name', 'Entrance Exam') }}
                                    {{ Form::text('entrance_exam', null, ['placeholder' => 'Entrance Exam', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4 form-group ">
                                    {{ Form::label('name', 'Deadline for Application') }}
                                    {{ Form::date('deadline', null, ['placeholder' => 'Deadline for Application', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4 form-group ">
                                    {{ Form::label('name', 'Examination Fees') }}
                                    {{ Form::text('exam_fees', null, ['placeholder' => 'Examination Fees', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4 form-group ">
                                    {{ Form::label('name', 'Tuition Fees') }}
                                    {{ Form::text('tuition_fees', null, ['placeholder' => 'Tuition Fees', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4 form-group ">
                                    {{ Form::label('name', 'Session') }}
                                    {{ Form::text('session', null, ['placeholder' => 'Session', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4 form-group ">
                                    {{ Form::label('name', 'Placement Information') }}
                                    {{ Form::text('pinfo', null, ['placeholder' => 'Placement Information', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-12 form-group ">
                                    {{ Form::label('examination accepted', 'Examination Accepted') }}
                                    {{ Form::text('exam_accept', null, ['placeholder' => 'Examination Accepted', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-12 form-group">
                                    <h4>Renowned Faculties :-</h4>
                                </div>
                                @for($i=0; $i<=2; $i++)
                                <div class="col-md-4 form-group ">
                                    <input type="file" name="renowned_img[]" class="form-control">
                                    {{ Form::text('rfaculties[]', null, ['placeholder' => 'Renowned Faculties', 'class' => 'form-control']) }}
                                </div>
                                @endfor
                                <input type="hidden" name="page" class="page" value="4">
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

<div class="gallery_img hidden ">
    <div class="col-md-12 form-group gall">
        {{ Form::text('name[]', null, ['placeholder' => 'Course Name','onblur'=>'getCourseName()', 'class' => 'form-control gall','required'=>'required']) }}
    </div>
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




