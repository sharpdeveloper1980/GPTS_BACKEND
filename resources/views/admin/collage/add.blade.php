@extends('admin.layouts.app')

@section('title', 'Add Collage')

@section('content')

@include('admin.layouts.header')

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style>
    select.selectpicker { display:none; /* Prevent FOUC */}
</style>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add College</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add New College</h3>
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
                            <div class="col-md-4 form-group">
                                {{ Form::label('collageType', 'College Type') }}<span class="required">*</span>
                                {{ Form::select('collage_type', @$collageType,'',['class' => 'form-control chosen-select'])}}
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('universityType', 'University Type') }}<span class="required">*</span>
                                {{ Form::select('university_type', @$universityType,'',['class' => 'form-control chosen-select'])}}
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('ttecareer', 'TTE Careers') }}<span class="required">*</span>
                                <select name="tte_career[]" class="selectpicker form-control" data-live-search="true" multiple>
                                    @foreach($tte_careers as $row)
                                    <option value="{{ $row['tte_career_id'] }}">{{ $row['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Name of Institute') }}<span class="required">*</span>
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
                                {{ Form::label('Mobile No', 'Mobile No.') }}<span class="required">*</span>
                                {{ Form::text('mobile_no', null, ['placeholder' => 'Mobile Number', 'class' => 'form-control','required'=>'required']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Landline No.', 'Landline No') }}
                                {{ Form::text('landline_no', null, ['placeholder' => 'Landline Number', 'class' => 'form-control']) }}
                            </div>
                            <div class=" col-md-6 form-group">
                                {{ Form::label('Alternative No.', 'Alternative No') }}
                                {{ Form::text('alternative_no', null, ['placeholder' => 'Alternative Number', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Average Package Offered.', 'Average Package Offered') }}
                                {{ Form::text('average_package_offer', null, ['placeholder' => 'Average Package Offered', 'class' => 'form-control']) }}
                            </div>

                            <div class=" col-md-4 form-group">
                                {{ Form::label('Area', 'Area') }}
                                {{ Form::text('area', null, ['placeholder' => 'Area In Sq. Feet', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('Year', 'Year') }}
                                {{ Form::text('year_of_build', null, ['placeholder' => 'Year', 'class' => 'form-control']) }}
                            </div>

                            <div class="col-md-4 form-group">
                                {{ Form::label('Country', 'Country') }}
                                {{ Form::text('country', null, ['placeholder' => 'Country', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('Degree', 'Country') }}
                                {{ Form::text('degree', null, ['placeholder' => 'Degree', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('Rating', 'Rating') }}
                                {{ Form::text('total_rating', null, ['placeholder' => 'Total Rating', 'class' => 'form-control']) }}
                            </div>

                            <div class="col-md-4 form-group">
                                {{ Form::label('Total Students', 'Total Enrolled Students') }}
                                {{ Form::text('total_students', null, ['placeholder' => 'Total Enrolled Students', 'class' => 'form-control']) }}
                            </div>

                            <div class="col-md-12 form-group">
                                {{ Form::label('Addresss', 'Address') }}<span class="required">*</span>
                                {{Form::textarea('address',null,['class'=>'form-control', 'rows' => 8, 'cols' => 40])}}
                            </div>


                        </div>
                        <!--Basic Info End-->
                        <div class="row form-group">
                            <div class="col-md-12 form-group">
                                <h4>Student Satisfaction Report :-</h4>
                            </div>
                            <div class="col-md-2 text-center form-group">
                                <input type="hidden" name="usertype" value="<?php echo Config::get('constants.CollegeType') ?>">
                                {{ Form::text('infrastructure', null, ['placeholder' => 'Infrastructure','class' => 'form-control']) }}
                                {{ Form::label('name', 'Infrastructure') }}
                            </div>
                            <div class="col-md-2 text-center form-group">

                                {{ Form::text('life_on_capm', null, ['placeholder' => 'Life on Campus','class' => 'form-control']) }}
                                {{ Form::label('name', 'Life on Campus') }}
                            </div>
                            <div class="col-md-2 text-center form-group">

                                {{ Form::text('learn_exp', null, ['placeholder' => 'Learning Experience','class' => 'form-control']) }}
                                {{ Form::label('name', 'Learning Experience') }}
                            </div>
                            <div class="col-md-2 text-center form-group">

                                {{ Form::text('extra_curr', null, ['placeholder' => 'Extra curriculars','class' => 'form-control']) }}
                                {{ Form::label('name', 'Extra curriculars') }}
                            </div>
                            <div class="col-md-2 text-center form-group">

                                {{ Form::text('happi_quot', null, ['placeholder' => 'Happiness Quotient','class' => 'form-control']) }}
                                {{ Form::label('name', 'Happiness Quotient') }}
                            </div>
                            <div class="col-md-2 text-center form-group">

                                {{ Form::text('alumni_value', null, ['placeholder' => 'Alumni Value Score','class' => 'form-control']) }}
                                {{ Form::label('name', 'Alumni Value Score') }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('SSI Report', 'SSI Report') }}

                                <input type="file" name="ssi_report" class="form-control">
                            </div>
                        </div>
                        <!--About Institute Start-->
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                <h4>About Institute :-</h4>
                            </div>


                            <div class="col-md-6 form-group">
                                {{ Form::label('Logo.', 'Logo') }}

                                <input type="file" name="logo" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Cover Image.', 'Cover Image') }}
                                <input type="file" name="cover_img" class="form-control">
                            </div>



                            <div class="col-md-12 form-group">
                                {{ Form::label('About the Institute', 'About the Institute') }}
                                {{Form::textarea('about',null,['class'=>'form-control', 'rows' => 8, 'cols' => 40])}}
                            </div>

                        </div>

                        <!--About Institute End-->
                        <!--Facilities at the Institute Start-->
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                <h4>Why choose institute :-</h4>
                            </div>
                            @for($i=0; $i<=3; $i++)
                            <div class="col-md-3 form-group">
                                {{ Form::text('choose_title[]', null, ['placeholder' => 'Title', 'class' => 'form-control']) }}
                                {{Form::textarea('choose_desc[]',null,['class'=>'form-control ','placeholder' => 'Description' ,'rows' => 8, 'cols' => 40])}}
                            </div>
                            @endfor
                        </div>
                        <!--Facilities at the Institute End-->
                           <!--Facilities at the Institute Start-->
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                <h4>Facilities at the Institute :-</h4>
                            </div>
                            @for($i=0; $i<=5; $i++)
                            <div class="col-md-2 form-group">
                                <!--{{ Form::select('icon[]', @$facIcons,'',['class' => 'form-control '])}}-->
                                <select title="Select facalities icon" name="icon[]" class="form-control selectpicker">
                                    <option value="">Select...</option>
                                    @foreach($facIcons as $value)
                                <option value="{{$value['img']}}" data-thumbnail="{{URL::asset("/public/image/facalitiesicons/".$value['img'])}}">{{$value['title']}}</option>
                                    @endForeach
                                </select>

                                <!--{{ Form::text('fac_name[]', null, ['placeholder' => 'Faculty Name', 'class' => 'form-control']) }}-->
                            </div>
                            @endfor
                        </div>
                        <!--Facilities at the Institute End-->
                        <!--Prominent Recruiters Start-->
                        <div class="row form-group">

                            <div class="col-md-12">
                                <h4>Prominent Recruiters :-</h4>
                            </div>
                            @for($i=0; $i<=2; $i++)
                            <div class="col-md-4">
                                <input type="file" name="pro_logo[]" class="form-control">
                                {{ Form::text('compy_name[]', null, ['placeholder' => 'Company Name', 'class' => 'form-control']) }}
                                {{ Form::number('av_salary[]',null,['placeholder'=>'avg. salary offered','class'=>'form-control']) }}
                                
                            </div>
                            @endfor

                        </div>
                        <!--Prominent Recruiters End-->
                     
                        <!--Popular Alumni Start-->
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                <h4>Words That Matter :-</h4>
                            </div>
                            @for($i=0; $i<=2; $i++)
                            <div class="col-md-4 form-group">

                                <input type="file" name="alumni_pic[]" class="form-control">
                                {{Form::text('alumni_title[]',null,['placeholder'=>'Name','class'=>'form-control'])}}
                                {{Form::text('alumni_desi[]',null,['placeholder'=>'Designation','class'=>'form-control'])}}
                                {{Form::text('alumni_company[]',null,['placeholder'=>'Company','class'=>'form-control'])}}
                                {{Form::textarea('alumni_desc[]',null,['placeholder'=>'Message','class'=>'form-control ', 'rows' => 5, 'cols' => 40])}}

                            </div>

                            @endfor
                        </div>
                        <div class="row form-group">
                        <div class=" col-md-4 form-group">
                                {{ Form::label('Master Video Brief', 'Master Video Brief') }}
                                {{ Form::text('video_brief', null, ['placeholder' => 'Master Video Brief', 'class' => 'form-control']) }}
                        </div>
                        <div class="col-md-4 form-group">
                                {{ Form::label('Video Thumbnail', 'Video Thumbnail') }}
                                <input type="file" name="video_thumb" class="form-control">
                            </div>

                            <div class="col-md-4 form-group">
                                {{ Form::label('name', 'Video') }}
                                <input type="file" name="video" class="form-control">
                            </div>
                        </div>
                        <!--Popular Alumni End-->

                        

                        <!--Popular Alumni Start-->
                        <!--<div class="row">
                            <div class="col-md-12 form-group">

                                <h4>Message from Head of Institute :-</h4>
                                <input type="file" name="head_inst_img" class="form-control">
                          
                                {{Form::textarea('head_inst_msg',null,['class'=>'form-control','placeholder'=>'Please Input some Message here' ,'rows' => 5, 'cols' => 40])}}



                            </div>
                        </div>-->
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




