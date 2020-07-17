@extends('admin.layouts.app')

@section('title', 'Edit College')

@section('content')

@include('admin.layouts.header')

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit College
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">

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
                    {{ Form::model($user, ['method' => 'post','url' => ['/admin/edit-college', @$user->id] ,'files' => true]) }}
                    {{csrf_field()}}
                    <div class="box-body">
                        <!--Basic Info Start-->
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                <h4>Basic Information :-</h4>
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('collageType', 'College Type') }}<span class="required">*</span>
                                {{ Form::select('collage_type', @$collageType,@$user['college']->collage_type,['class' => 'form-control'])}}
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('universityType', 'University Type') }}<span class="required">*</span>
                                {{ Form::select('university_type', @$universityType,@$user['college']->university_affiliated,['class' => 'form-control'])}}
                            </div>
                            <div class="col-md-4 form-group">
                                @php $selected_careers=explode(',',$user["college"]->tte_career) @endphp

                                {{ Form::label('ttecareer', 'TTE Careers') }}<span class="required">*</span>
                                <select name="tte_career[]" class="selectpicker form-control" data-live-search="true" multiple>
                                    @foreach($tte_careers as $row)
                                    <option value="{{ $row['tte_career_id'] }}" @php if(in_array($row["tte_career_id"],$selected_careers)){ echo 'selected';}  @endphp
                                >{{ $row['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Name of Institute') }}<span class="required">*</span>
                                {{ Form::text('name', @$user->name, ['placeholder' => 'Name of Institute', 'class' => 'form-control title','required'=>'required']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Slug', 'Slug') }}<span class="required">*</span>
                                {{ Form::text('slug', @$user['college']->slug, ['placeholder' => 'Slug', 'class' => 'form-control slug','required'=>'required']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Website', 'Website') }}<span class="required">*</span>
                                {{ Form::text('website', @$user['college']->website, ['placeholder' => 'Website', 'class' => 'form-control','required'=>'required']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Email Id', 'Email Id') }}<span class="required">*</span>
                                {{ Form::email('email', @$user->email, ['placeholder' => 'Email Id', 'class' => 'form-control','required'=>'required']) }}
                            </div>

                            <div class="col-md-6 form-group">
                                {{ Form::label('Mobile No', 'Mobile No.') }}<span class="required">*</span>
                                {{ Form::text('mobile_no', @$user['college']->phone_no, ['placeholder' => 'Mobile Number', 'class' => 'form-control','required'=>'required']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Landline No.', 'Landline No') }}
                                {{ Form::text('landline_no', @$user['college']->landline_no, ['placeholder' => 'Landline Number', 'class' => 'form-control']) }}
                            </div>
                            <div class=" col-md-6 form-group">
                                {{ Form::label('Alternative No.', 'Alternative No') }}
                                {{ Form::text('alternative_no', @$user['college']->alternative_no, ['placeholder' => 'Alternative Number', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Average Package Offered.', 'Average Package Offered') }}
                                {{ Form::text('average_package_offer', @$user['college']->average_package_offer, ['placeholder' => 'Average Package Offered', 'class' => 'form-control']) }}
                            </div>

                            <div class=" col-md-4 form-group">
                                {{ Form::label('Area', 'Area') }}
                                {{ Form::text('area', @$user['college']->area, ['placeholder' => 'Area In Sq. Feet', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('Year', 'Year') }}
                                {{ Form::text('year_of_build', @$user['college']->year_of_build, ['placeholder' => 'Year', 'class' => 'form-control']) }}
                            </div>

                            <div class="col-md-4 form-group">
                                {{ Form::label('Country', 'Country') }}
                                {{ Form::text('country', @$user['college']->country, ['placeholder' => 'Country', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('Degree', 'Degree') }}
                                {{ Form::text('degree', @$user['college']->degree, ['placeholder' => 'Degree', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('Rating', 'Rating') }}
                                {{ Form::text('total_rating', @$user['college']->total_rating, ['placeholder' => 'Total Rating', 'class' => 'form-control']) }}
                            </div>

                            <div class="col-md-4 form-group">
                                {{ Form::label('Total Students', 'Total Enrolled Students') }}
                                {{ Form::text('total_students', @$user['college']->total_students, ['placeholder' => 'Total Enrolled Students', 'class' => 'form-control']) }}
                            </div>

                            <div class="col-md-12 form-group">
                                {{ Form::label('Addresss', 'Address') }}<span class="required">*</span>
                                {{Form::textarea('address',@$user['college']->address,['class'=>'form-control', 'rows' => 8, 'cols' => 40])}}
                            </div>


                        </div>
                        <!--Basic Info End-->
                        <div class="row form-group">
                            <div class="col-md-12 form-group">
                                <h4>Student Satisfaction Report :-</h4>
                            </div>
                            <div class="col-md-2 text-center form-group">

                                {{ Form::text('infrastructure', @$user['college']->infrastructure, ['placeholder' => 'Infrastructure','class' => 'form-control']) }}
                                {{ Form::label('name', 'Infrastructure') }}
                            </div>
                            <div class="col-md-2 text-center form-group">

                                {{ Form::text('life_on_capm', @$user['college']->life_on_capm, ['placeholder' => 'Life on Campus','class' => 'form-control']) }}
                                {{ Form::label('name', 'Life on Campus') }}
                            </div>
                            <div class="col-md-2 text-center form-group">

                                {{ Form::text('learn_exp', @$user['college']->learn_exp, ['placeholder' => 'Learning Experience','class' => 'form-control']) }}
                                {{ Form::label('name', 'Learning Experience') }}
                            </div>
                            <div class="col-md-2 text-center form-group">

                                {{ Form::text('extra_curr', @$user['college']->extra_curr, ['placeholder' => 'Extra curriculars','class' => 'form-control']) }}
                                {{ Form::label('name', 'Extra curriculars') }}
                            </div>
                            <div class="col-md-2 text-center form-group">

                                {{ Form::text('happi_quot', @$user['college']->happi_quot, ['placeholder' => 'Happiness Quotient','class' => 'form-control']) }}
                                {{ Form::label('name', 'Happiness Quotient') }}
                            </div>
                            <div class="col-md-2 text-center form-group">
                                <input type="hidden" name="usertype" value="<?php echo Config::get('constants.CollegeType') ?>">
                                {{ Form::text('alumni_value', @$user['college']->alumni_value, ['placeholder' => 'Alumni Value Score','class' => 'form-control']) }}
                                {{ Form::label('name', 'Alumni Value Score') }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('SSI Report', 'SSI Report') }}
                                @if($user['college']->ssi_report!='')
                                <a href="{{URL::asset("/public/satisfaction-report/".$user['college']->ssi_report)}}" target="blank">View</a>
                                @endif

                                <input type="file" name="ssi_report" class="form-control">

                            </div>
                        </div>
                        <!--About Institute Start-->
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                <h4>About Institute :-</h4>
                            </div>


                            <div class="col-md-6 form-group">
                                {{ Form::label('Logo.', 'Logo') }}<br>
                                @if($user['college']->logo!='')
                                <img src="{{URL::asset("/public/image/logo/".$user['college']->logo)}}" width="200" height="200">
                                @else
                                <img src="https://via.placeholder.com/200" width="200" height="200" >
                                @endif
                                <input type="file" name="logo" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Cover Image.', 'Cover Image') }}<br>
                                @if($user['college']->cover_logo!='')
                                <img src="{{URL::asset("/public/image/coverimg/".$user['college']->cover_logo)}}" width="200" height="200" >
                                @else
                                <img src="https://via.placeholder.com/200" width="200" height="200" >
                                @endif
                                <input type="file" name="cover_img" class="form-control">
                            </div>



                            <div class="col-md-12 form-group">
                                {{ Form::label('About the Institute', 'About the Institute') }}
                                {{Form::textarea('about',@$user['college']->about,['class'=>'form-control', 'rows' => 8, 'cols' => 40])}}
                            </div>

                        </div>

                        <!--About Institute End-->
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                <h4>Why choose institute :-</h4>
                            </div>
                            @for($i=0; $i<=3; $i++)
                             @if($user['collegechoose']->count() > 0)
                              <div class="col-md-3 form-group">
                                {{ Form::text('choose_title[]',@$user['collegechoose'][$i]->text , ['placeholder' => 'Title', 'class' => 'form-control']) }}
                                {{Form::textarea('choose_desc[]',@$user['collegechoose'][$i]->descr,['class'=>'form-control','placeholder' => 'Description', 'rows' => 8, 'cols' => 40])}}
                            </div>
                             @else
                            <div class="col-md-3 form-group">
                                {{ Form::text('choose_title[]', null, ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                                {{Form::textarea('choose_desc[]',null,['class'=>'form-control', 'rows' => 8, 'cols' => 40])}}
                            </div>
                            @endif
                             @endfor
                        </div>
                             <!--Facilities at the Institute Start-->
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                <h4>Facilities at the Institute :-</h4>
                            </div>
                            @for($i=0; $i<=5; $i++)
                            @if($user['collegefac']->count() > 0)
                            
                            <div class="col-md-2">
                                <select title="Select facalities icon" name="icon[]" class="form-control selectpicker">
                                    <option>Select...</option>
                                    @foreach($facIcons as $value)
                                    <option value="{{$value['img']}}" <?php if(isset($user['collegefac'][$i]->icon) && $value['img']==$user['collegefac'][$i]->icon){ echo 'selected';}?> data-thumbnail="{{URL::asset("/public/image/facalitiesicons/".$value['img'])}}">{{$value['title']}}</option>
                                    @endForeach
                                </select>
<!--                                {{ Form::text('icon[]', @$user['collegefac'][$i]->icon, ['placeholder' => 'Icon', 'class' => 'form-control']) }}
                                {{ Form::text('fac_name[]', @$user['collegefac'][$i]->fac_name, ['placeholder' => 'Faculty Name', 'class' => 'form-control']) }}-->
                            </div>
                            
                            @else
                            <div class="col-md-2 form-group">
                                <select title="Select faculty icon" name="icon[]" class="form-control selectpicker">
                                    <option>Select...</option>
                                    @foreach($facIcons as $value)
                                    <option value="{{$value['img']}}"  data-thumbnail="{{URL::asset("/public/image/facultyicons/".$value['img'])}}">{{$value['title']}}</option>
                                    @endForeach
                                </select>
<!--                                {{ Form::text('icon[]', null, ['placeholder' => 'Icon', 'class' => 'form-control']) }}
                                {{ Form::text('fac_name[]', null, ['placeholder' => 'Faculty Name', 'class' => 'form-control']) }}-->
                            </div>
                            
                            @endif
                            @endfor
                        </div>
                        <!--Facilities at the Institute End-->
                        <!--Prominent Recruiters Start-->
                        <div class="row form-group">

                            <div class="col-md-12">
                                <h4>Prominent Recruiters :-</h4>
                            </div>
                            @for($i=0; $i<=2; $i++)
                            @if($user['collegepro']->count() > 0)

                            <div class="col-md-4">
                                  @if(isset($user['collegepro'][$i]->logo) && $user['collegepro'][$i]->logo!='')
                                <img src="{{URL::asset("/public/image/recruiters_image/".$user['collegepro'][$i]->logo)}}" width="100%" height="200" >
                                <input type="hidden" name="pro_img[]" value="{{$user['collegepro'][$i]->logo}}">
                                @else
                                <img src="https://via.placeholder.com/200" width="100%" height="200" >
                                <input type="hidden" name="pro_img[]" value="">
                                @endif
                                <input type="file" name="pro_logo[]" class="form-control">
                                {{ Form::text('compy_name[]', @$user['collegepro'][$i]->compy_name, ['placeholder' => 'Company Name', 'class' => 'form-control']) }}
                                {{ Form::number('av_salary[]',@$user['collegepro'][$i]->av_salary,['placeholder'=>'avg. salary offered','class'=>'form-control']) }}
                                
                            </div>

                            @else
                            <div class="col-md-4">
                                <input type="file" name="pro_logo[]" class="form-control">
                                {{ Form::text('compy_name[]', null, ['placeholder' => 'Company Name', 'class' => 'form-control']) }}
                                {{ Form::number('av_salary[]',null,['placeholder'=>'avg. salary offered','class'=>'form-control']) }}
                            </div>

                            @endif
                            @endfor
                        </div>
                        <!--Prominent Recruiters End-->

                        <!--Popular Alumni Start-->
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                <h4>Words That Matter :-</h4>
                            </div>
                            @for($i=0; $i<=2; $i++)
                            @if($user['collegeAlumni']->count() > 0)
                            
                            
                            <div class="col-md-4 form-group">
                                @if(isset($user['collegeAlumni'][$i]->alumni_pic) && $user['collegeAlumni'][$i]->alumni_pic!='')
                                <img src="{{URL::asset("/public/image/alumni_pic/".$user['collegeAlumni'][$i]->alumni_pic)}}" width="100%" height="200" >
                                <input type="hidden" name="alm_img[]" value="{{$user['collegeAlumni'][$i]->alumni_pic}}">
                                @else
                                <img src="https://via.placeholder.com/200" width="100%" height="200" >
                                <input type="hidden" name="alm_img[]" value="">
                                @endif
                                <input type="file" name="alumni_pic[]" class="form-control">
                                {{Form::text('alumni_title[]',@$user['collegeAlumni'][$i]->title,['placeholder'=>'Name','class'=>'form-control'])}}					
                                {{Form::text('alumni_desi[]',@$user['collegeAlumni'][$i]->designation,['placeholder'=>'Designation','class'=>'form-control'])}}
                                {{Form::text('alumni_company[]',@$user['collegeAlumni'][$i]->company_name,['placeholder'=>'Company','class'=>'form-control'])}}		
                                {{Form::textarea('alumni_desc[]',@$user['collegeAlumni'][$i]->alumni_desc,['placeholder'=>'Message','class'=>'form-control', 'rows' => 5, 'cols' => 40])}}

                            </div>
                           
                            @else
                            <div class="col-md-4 form-group">

                                <input type="file" name="alumni_pic[]" class="form-control">
                                {{Form::text('alumni_title[]',null,['placeholder'=>'Tittle','class'=>'form-control'])}}	
                                {{Form::text('alumni_desi[]',null,['placeholder'=>'Designation','class'=>'form-control'])}}
                                {{Form::text('alumni_company[]',null,['placeholder'=>'Company','class'=>'form-control'])}}							
                                {{Form::textarea('alumni_desc[]',null,['placeholder'=>'Message','class'=>'form-control', 'rows' => 5, 'cols' => 40])}}

                            </div>

                            @endif
                            @endfor
                        </div>
                        <div class="row form-group">
                            <div class=" col-md-4 form-group">
                                {{ Form::label('Master Video Brief', 'Master Video Brief') }}
                                {{ Form::text('video_brief', @$user['college']->video_brief, ['placeholder' => 'Master Video Brief', 'class' => 'form-control']) }}
                        </div>
                             <div class="col-md-4 form-group">
                                {{ Form::label('Video Thumbnail', 'Video Thumbnail') }}
                                <input type="file" name="video_thumb" class="form-control">
                                @if(@$user['college']->thumb!=null || @$user['college']->thumb!='')
                                <div class="bg_img" style="background:url(https://s3.eu-west-1.amazonaws.com/gpts-portal/college-video/thumb/{{@$user['college']->thumb}})">
                                </div>
                                @endif
                            </div>
                           

                            <div class="col-md-4 form-group">
                                {{ Form::label('name', 'Video') }}
                                <input type="file" name="video" class="form-control">
                                @if(@$user['college']->video!=null || @$user['college']->video!='')
                                <video width="500" height="300" controls><source src="https://s3.eu-west-1.amazonaws.com/gpts-portal/college-video/video/{{@$user['college']->video}}" type="video/mp4"></video>
                                @endif
                            </div>
                        </div>
                        <!--Popular Alumni End-->

                   

                        <!--Popular Alumni Start-->
                        <!--<div class="row">
                            <div class="col-md-12 form-group">

                                <h4>Message from Head of Institute :-</h4>
                                @if($user['college']->head_inst_img!='')
                                <img src="{{URL::asset("/public/image/".$user['college']->head_inst_img)}}" width="200" height="200">
                                @else
                                <img src="https://via.placeholder.com/200" width="200" height="200" >
                                @endif
                                <input type="file" name="head_inst_img" class="form-control">

                                {{Form::textarea('head_inst_msg',@$user['college']->head_inst_msg,['class'=>'form-control','placeholder'=>'Please Input some Message here' ,'rows' => 5, 'cols' => 40])}}



                            </div>-->
                    </div>
                    <!--Popular Alumni End-->
                </div>
                <div class="box-footer">
                    {{ Form::submit('Update', ['class' => 'btn btn-warning']) }}
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




