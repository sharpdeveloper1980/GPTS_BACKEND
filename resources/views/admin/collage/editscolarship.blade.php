@extends('admin.layouts.app')

@section('title', 'Edit Collage Scholarship')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{@$collegename->name}} Scholarship</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit College Scholarship</h3>
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
                    {{ Form::open(['url' => '/admin/save-scolarship', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
                    {{csrf_field()}}
                    <div class="box-body">

                        <div class="row form-group gallerylist">
                            <input type="hidden" name="page" class="page" value="1">
                            <input type="hidden" name="college_id" value="{{@$college_id}}">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success pull-right" onclick="addmore()"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-danger pull-right" onclick="remove()"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </div>
                            @if($scholarship->count() > 0)
                            @foreach($scholarship as $index => $value)
                            <div class="gall">
                                <div class="col-md-6 form-group">
                                    {{ Form::label('name', 'Scholarship Offered') }}<span class="required">*</span>
                                    {{ Form::text('scoller_offer[]', @$value->scoller_offer, ['placeholder' => 'Scholarship Offered', 'class' => 'form-control','required'=>'required']) }}
                                </div>

                                <div class="col-md-6 form-group">
                                    {{ Form::label('name', 'Application Process') }}
                                    {{ Form::text('appli_process[]', @$value->appli_process, ['placeholder' => 'Application Process', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('name', 'Last date of Application') }}
                                    {{ Form::date('last_date_to_appli[]', @$value->last_date_to_appli, ['placeholder' => 'Download Application', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('name', 'Download Application') }}
                                    @if(isset($value->download_appli) && $value->download_appli!='')
                                    <a href="{{URL::asset("/public/scolarship_appli/".$value->download_appli)}}" target="blank">View</a>  
                                    <input type="hidden" name="applidoc[]" value="{{$value->download_appli}}">
                                    @else

                                    <input type="hidden" name="applidoc[]" value="">
                                    @endif
                                    <input type="file" name="download_appli[]" class="form-control">

                                </div>
                                <div class="col-md-12 form-group">
                                    {{ Form::label('name', 'Eligibility Criteria') }}
                                    {{ Form::textarea('eligibility_criteria[]', @$value->eligibility_criteria, ['placeholder' => 'Eligibility Criteria', 'class' => 'form-control ckeditor']) }}
                                </div>

                            </div>
                            @endForeach
                            @else
                            <div class="gall">
                                <div class="col-md-6 form-group">
                                    {{ Form::label('name', 'Scholarship Offered') }}<span class="required">*</span>
                                    {{ Form::text('scoller_offer[]', null, ['placeholder' => 'Scholarship Offered', 'class' => 'form-control','required'=>'required']) }}
                                </div>

                                <div class="col-md-6 form-group">
                                    {{ Form::label('name', 'Application Process') }}
                                    {{ Form::text('appli_process[]', null, ['placeholder' => 'Application Process', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('name', 'Last date of Application') }}
                                    {{ Form::date('last_date_to_appli[]', null, ['placeholder' => 'Download Application', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('name', 'Upload Application') }}
                                    <input type="hidden" name="applidoc[]" value="">
                                    <input type="file" name="download_appli[]" class="form-control">
                                </div>
                                <div class="col-md-12 form-group">
                                    {{ Form::label('name', 'Eligibility Criteria') }}
                                    {{ Form::textarea('eligibility_criteria[]', null, ['placeholder' => 'Eligibility Criteria','id'=>'editor_1','onclick'=>'activeCkeditor(this)', 'class' => 'form-control']) }}
                                </div>
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
    <div class="gall">
        <div class="col-md-6 form-group">
            {{ Form::label('name', 'Scholarship Offered') }}<span class="required">*</span>
            {{ Form::text('scoller_offer[]', null, ['placeholder' => 'Scholarship Offered', 'class' => 'form-control','required'=>'required']) }}
        </div>

        <div class="col-md-6 form-group">
            {{ Form::label('name', 'Application Process') }}
            {{ Form::text('appli_process[]', null, ['placeholder' => 'Application Process', 'class' => 'form-control']) }}
        </div>
        <div class="col-md-6 form-group">
            {{ Form::label('name', 'Last date of Application') }}
            {{ Form::date('last_date_to_appli[]', null, ['placeholder' => 'Download Application', 'class' => 'form-control']) }}
        </div>
        <div class="col-md-6 form-group">
            {{ Form::label('name', 'Upload Application') }}
            <input type="hidden" name="applidoc[]" value="">
            <input type="file" name="download_appli[]" class="form-control">
        </div>
        <div class="col-md-12 form-group">
            {{ Form::label('name', 'Eligibility Criteria') }}
            {{ Form::textarea('eligibility_criteria[]', null, ['placeholder' => 'Eligibility Criteria','onclick'=>'activeCkeditor(this)', 'class' => 'form-control ck']) }}
        </div>
    </div>
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




