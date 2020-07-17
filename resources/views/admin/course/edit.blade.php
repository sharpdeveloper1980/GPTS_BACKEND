@extends('admin.layouts.app')

@section('title', 'Edit Course')

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
                        <h3 class="box-title">Edit college courses</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/view-course/'); !!}/{{$course->college_id}}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
                    {{ Form::model($course, ['method' => 'post','url' => ['/admin/edit-course', @$course->id] ,'files' => true]) }}
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                {{ Form::label('college', 'College') }}<span class="required">*</span>
                                {{ Form::select('college_id', @$college,@$course->college_id,['class' => 'chosen-select form-control'])}}

                            </div>
                        </div>
                        <div class="row form-group gallerylist">
                            <!--<div class="col-md-12 form-group">
                                <h4><button type="button" class="btn btn-success pull-right" onclick="addmore()"><i class="fa fa-plus" aria-hidden="true"></i></button>

                                </h4>
                            </div>-->
                            <div class="gall">
                                <div class="col-md-12 form-group gall_1">
                                    {{ Form::label('name', 'Course Name') }}<span class="required">*</span>
                                    {{ Form::text('name', @$course->name, ['placeholder' => 'Course Name', 'class' => 'form-control','required'=>'required']) }}
                                </div>
                                <div class="col-md-12 form-group gall_1">
                                    {{ Form::label('name', 'About Course') }}
                                    {{Form::textarea('about',@$course->about,['class'=>'form-control','placeholder' => 'Enter about course', 'rows' => 8, 'cols' => 40])}}
                                </div>
                                <div class="col-md-6 form-group gall_1">
                                    {{ Form::label('name', 'Admission System') }}
                                    {{ Form::text('admission_system', @$course->admission_system, ['placeholder' => 'Admission System', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-6 form-group gall_1">
                                    {{ Form::label('name', 'Duration') }}
                                    {{ Form::text('duration', @$course->duration, ['placeholder' => 'Duration', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-12 form-group gall_1">
                                    {{ Form::label('name', 'Eligibility Criteria') }}
                                    {{ Form::text('eligibility_criteria', @$course->eligibility_criteria, ['placeholder' => 'Eligibility Criteria', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4 form-group gall_1">
                                    {{ Form::label('name', 'Entrance Exam') }}
                                    {{ Form::text('entrance_exam', @$course->entrance_exam, ['placeholder' => 'Entrance Exam', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4 form-group gall_1">
                                    {{ Form::label('name', 'Deadline for Application') }}
                                    {{ Form::date('deadline', @$course->deadline, ['placeholder' => 'Deadline for Application', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4 form-group gall_1">
                                    {{ Form::label('name', 'Examination Fees') }}
                                    {{ Form::text('exam_fees', @$course->exam_fees, ['placeholder' => 'Examination Fees', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4 form-group gall_1">
                                    {{ Form::label('name', 'Tuition Fees') }}
                                    {{ Form::text('tuition_fees', @$course->tuition_fees, ['placeholder' => 'Tuition Fees', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4 form-group gall_1">
                                    {{ Form::label('name', 'Session') }}
                                    {{ Form::text('session', @$course->session, ['placeholder' => 'Session', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-4 form-group gall_1">
                                    {{ Form::label('name', 'Placement Information') }}
                                    {{ Form::text('pinfo', @$course->pinfo, ['placeholder' => 'Placement Information', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-12 form-group ">
                                    {{ Form::label('examination accepted', 'Examination Accepted') }}
                                    {{ Form::text('exam_accept', @$course->exam_accept, ['placeholder' => 'Examination Accepted', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-12 form-group">
                                    <h4>Renowned Faculties :-</h4>
                                </div>
                                @for($i=0; $i<=2; $i++)
                                <div class="col-md-4 form-group gall_1">
                                    @if(isset($course->rfac[$i]->path) && $course->rfac[$i]->path!='')
                                    <img src="{{URL::asset("/public/image/renowned_faculties/".$course->rfac[$i]->path)}}" width="100%" height="200" >
                                    <input type="hidden" name="re_img[]" value="{{$course->rfac[$i]->path}}">
                                    @else
                                    <input type="hidden" name="re_img[]" value="">
                                    <img src="https://via.placeholder.com/200" width="100%" height="200" >
                                    @endif
                                    <input type="file" name="renowned_img[]" class="form-control">
                                    {{ Form::text('rfacult[]',@$course->rfac[$i]->text, ['placeholder' => 'Renowned Faculties', 'class' => 'form-control']) }}
                                </div>
                                @endfor

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




