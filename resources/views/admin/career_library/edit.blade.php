@extends('admin.layouts.app')

@section('title', 'Edit Career Library')

@section('content')

@include('admin.layouts.header')
<style>
    select.selectpicker { display:none; /* Prevent FOUC */}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit {{$type}} Library</h1>
    </section>
    <section class="content">   
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit {{$type}} Library</h3>
                        <div class="pull-right">
                            @if($type=='Sub Career')
                            <a href="{!! url('/admin/edit-sub-career'); !!}/{{$career->parent}}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
                        @else
                        <a href="{!! url('/admin/career'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
                        @endif
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

                    {{ Form::model($career, ['method' => 'post','url' => ['/admin/edit-career', @$career->id] ,'files' => true]) }}
                    {{csrf_field()}}

                    <div class="box-body">
                        <div class="row form-group">

                            <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Career Name') }}<span class="required">*</span>
                                {{ Form::text('name', @$career->name, ['placeholder' => 'Name of Career', 'class' => 'form-control title','required'=>'required']) }}
                            </div>

                            <div class="col-md-6 form-group">
                                {{ Form::label('Slug', 'Slug') }}<span class="required">*</span>
                                <input type="hidden" name="career_type" value="{{@$career->type}}">
                                {{ Form::text('slug', @$career->slug, ['placeholder' => 'Slug', 'class' => 'form-control slug','required'=>'required']) }}
                            </div>

                        </div>
                        @if($career->type==1)
                            <div class="row form-group ">
                                <div class="col-md-3 form-group">
                                    {{ Form::label('Type', 'Career TTE Unique Id') }}<span class="required">*</span>
                                    {{ Form::select('tte_career_id', $TteIdList,@$career->tte_career_id, ['class' => 'form-control ','required'=>'required']) }}
                                </div>
                                <div class="col-md-3 form-group">
                                    {{ Form::label('Edieo Cluster Thumbnail', 'Edieo Cluster Thumbnail') }}
                                    <a href="https://s3.eu-west-1.amazonaws.com/gpts-portal/career/career-video/{{$career->edieo_thumb}}" target="blank">View</a>
                                    <input type="file" name="edieo_thumb" class="form-control">
                                </div>
                                 <div class="col-md-3 form-group">
                                    {{ Form::label('Edieo College Thumbnail', 'Edieo College Thumbnail') }}
                                    <a href="https://s3.eu-west-1.amazonaws.com/gpts-portal/career/career-video/{{$career->edieo_cluster_thumb}}" target="blank">View</a>
                                    <input type="file" name="edieo_cluster_thumb" class="form-control">
                                </div>
                                <div class="col-md-3 form-group">
                                    {{ Form::label('industry expert', 'Industry Expert Video') }}
                                    <a href="https://s3.eu-west-1.amazonaws.com/gpts-portal/career/career-video/{{$career->exp_video}}" target="blank">View</a>
                                    <input type="file" name="exp_video" class="form-control" id="fl">
                                </div>
                                <div class="col-md-3 form-group">
                                    {{ Form::label('Video Thumbnail', 'Video Thumbnail') }}
                                     @if($career->video_thumb!='')
                                    <a href="https://s3.eu-west-1.amazonaws.com/gpts-portal/career/career-video/{{$career->video_thumb}}" target="blank">View</a>
                                    @endif
                                    <input type="file" name="video_thumb"  class="form-control imagefl">
                                </div>
                                <div class="col-md-3 form-group">
                                    {{ Form::label('College Cluster Video', 'College Cluster Video') }}
                                     @if($career->cluster_video!='')
                                    <a href="https://s3.eu-west-1.amazonaws.com/gpts-portal/career/discover/{{$career->cluster_video}}" target="blank">View</a>
                                    @endif
                                    <input type="file" name="cluster_video" class="form-control" id="f1">
                                </div>
                                <div class="col-md-3 form-group">
                                    {{ Form::label('College Cluster Thumbnail', 'College Cluster Thumbnail') }}
                                     @if($career->cluster_thumb!='')
                                    <a href="https://s3.eu-west-1.amazonaws.com/gpts-portal/career/discover/{{$career->cluster_thumb}}" target="blank">View</a>
                                    @endif
                                    <input type="file" name="cluster_thumb"  class="form-control imagefl">
                                </div>
                            </div>
                            <div class="row form-group cat">
                                <div class="col-md-6 form-group">
                                    {{ Form::label('Video title', 'Video Name') }}
                                    {{ Form::text('video_title', @$career->video_title, ['placeholder' => 'Video Name', 'class' => 'form-control']) }}
                                </div> 
                                <div class="col-md-6 form-group">
                                    {{ Form::label('Video Designation', 'Video Designation') }}
                                    {{ Form::text('video_designation', @$career->video_designation, ['placeholder' => 'Video Designation', 'class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-3 form-group">
                                    {{ Form::label('No. of Colleges', 'No. of Colleges') }}
                                    {{ Form::number('college_no', @$career->college_no, ['placeholder' => 'No. of Colleges', 'class' => 'form-control']) }}
                                </div> 
                                <div class="col-md-3 form-group">
                                    {{ Form::label('Undergraduate Programme', 'Undergraduate Programme') }}
                                    {{ Form::number('under_programme', @$career->under_programme, ['placeholder' => 'Undergraduate Programme', 'class' => 'form-control']) }}
                                </div>
                                <div class="col-md-3 form-group">
                                    {{ Form::label('Students Enrolled', 'Students Enrolled') }}
                                    {{ Form::number('students_enrolled', @$career->students_enrolled, ['placeholder' => 'Students Enrolled', 'class' => 'form-control']) }}
                                </div> 
                                <div class="col-md-3 form-group">
                                    {{ Form::label('Average Fees', 'Average Fees') }}
                                    {{ Form::text('average_fees', @$career->average_fees, ['placeholder' => 'Average Fees', 'class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-8 form-group">
                                    {{ Form::label('Quotes', 'Quotes') }}
                                    {{ Form::text('quotes', @$career->quotes, ['placeholder' => 'Quotes', 'class' => 'form-control']) }}
                                </div> 
                                <div class="col-md-4 form-group">
                                    {{ Form::label('Person Name', 'Person Name') }}
                                    {{ Form::text('person_name', @$career->person_name, ['placeholder' => 'Quotes Person Name', 'class' => 'form-control']) }}
                                </div>
                            </div>
                        @endif
                         <div class="row form-group">
                            
                            <div class="col-md-3 form-group">
                                <label for="Cluster Image">Cluster Image</label>
                                @if($career->cluster_image!='')
                                <a href="https://s3.eu-west-1.amazonaws.com/gpts-portal/career/discover/{{$career->cluster_image}}" target="blank">View</a>
                                @endif
                                <input type="file" name="cluster_image" class="form-control imagefl">
                            </div>

                            <div class="col-md-3 form-group">
                                {{ Form::label('Career Banner', 'Career Banner') }}
                                @if($career->career_banner!='')
                                <a href="https://s3.eu-west-1.amazonaws.com/gpts-portal/career/career-banner/{{$career->career_banner}}" target="blank">View</a>
                                @endif
                                <input type="file" name="career_banner" class="form-control imagefl">
                            </div>
                            <div class="col-md-3 form-group">
                                {{ Form::label('logo', 'Career Icon') }}
                                 @if($career->career_icon!='')
                                <a href="https://s3.eu-west-1.amazonaws.com/gpts-portal/career/career-icon/{{$career->career_icon}}" target="blank">View</a>
                                @endif
                                <input type="file" name="career_icon" class="form-control imagefl">
                            </div>
                            <div class="col-md-3 form-group">
                                {{ Form::label('Career Image', 'Career Image') }}
                                 @if($career->career_image!='')
                                <a href="https://s3.eu-west-1.amazonaws.com/gpts-portal/career/career-icon/{{$career->career_image}}" target="blank">View</a>
                                @endif
                                <input type="file" name="career_image" class="form-control">
                            </div>
                        </div>
                         <div class="row form-group">
                            <div class="col-md-12 form-group">
                                {{ Form::label('Footer Quote', 'Footer Quote') }}<span class="required">*</span>
                                {{ Form::text('banner_title', @$career->banner_title, ['placeholder' => 'Footer Quote', 'class' => 'form-control ','required'=>'required']) }}
                            </div>
                        </div>
                        @if($career->type==2)
                        <div class="row form-group sub_cat">
                            <div class="col-md-6 form-group">
                             {{ Form::label('Type', 'Career List') }}<span class="required">*</span>
                             {{ Form::select('parent_id', $careerlist,@$career->parent, ['class' => 'form-control ','required'=>'required']) }}                            
                        </div>
                             <div class="col-md-6 form-group">
                                {{ Form::label('Type', 'Beginning Minimum Salary') }}
                                {{ Form::text('salary', @$career->salary, ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 form-group">
                                {{ Form::label('career_ladder', 'Career Ladder') }}
                            </div>
                            @foreach($career->career_ladder as $option)
                            <div class="col-md-2 form-group">
                                {{ Form::text('career_ladders[]', $option, ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                            </div>
                            @endforeach
                        </div>
                        @endif
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                {{ Form::label('about', 'About Career') }}<span class="required">*</span>
                                {{Form::textarea('about',@$career->about,['class'=>'form-control', 'rows' => 4, 'cols' => 50, 'required'=>'required'])}}
                            </div>

                        </div>
                        
                        @if($career->type==2)
                        <div class="row form-group">
                            <div class="col-md-12 form-group">
                                <h4>Area Cover :-</h4>
                            </div>
                            @foreach($career->area_cover as $option)
                            <div class="col-md-2 form-group">
                                {{ Form::text('area_covers[]', $option, ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                            </div>
                            @endforeach
                        </div>
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                {{ Form::label('key psychology', 'key psychology') }}
                                {{Form::textarea('key_psychology',$career->key_psychology,['class'=>'form-control', 'rows' => 4, 'cols' => 50])}}
                            </div>

                        </div>
                        <div class="row form-group sub_cat">
                            <div class="col-md-12 form-group">
                                <h4>Related Career:-</h4>
                            </div>
                             @foreach($career->related_career as $value)
                            <div class="col-md-3 form-group">
                                {{ Form::text('related_title[]', $value->title, ['placeholder' => 'Title', 'class' => 'form-control']) }}
                                {{Form::textarea('related_desc[]',$value->description,['placeholder' => 'Description','class'=>'form-control', 'rows' => 4, 'cols' => 50])}}
                            </div>
                            @endforeach
                            
                        </div>

                        <div class="row form-group hidden">

                            <div class="col-md-12 form-group">
                                <h4>Fields Of Specialization :-</h4>
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('undergraduate_eligibility_criteria', 'For Undergraduate') }}
                                {{ Form::text('undergraduate_eligibility_criteria', null, ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('postgraduate_eligibility_criteria', 'For Post Graduate') }}
                                {{ Form::text('postgraduate_eligibility_criteria', null, ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                            </div>

                        </div>

                        <!--<div class="row form-group">

                                <div class="col-md-12 form-group">
                                    <h4>GPTS Certified Colleges :-</h4>
                                </div>
                                @for($i=0; $i<=3; $i++)
                                <div class="col-md-3 form-group">
                                    <input type="file" name="certified_logo[]" class="form-control">
                                    {{ Form::text('certified_text[]', null, ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                                </div>
                                @endfor

                        </div>-->
                        <div class="row form-group hidden">

                            <div class="col-md-12 form-group">
                                <h4>Top Recruiters :-</h4>
                            </div>
                            @if(!empty($career->top_recruiters))
                            @foreach($career->top_recruiters as $key)
                            <div class="col-md-3 form-group">
                                <input type="file" name="recruiters_img[]" class="form-control">
                                <input type="hidden" name="timg[]" value="{{@$key->img}}">
                                {{ Form::text('top_recruiters[]',(isset($key->text))?$key->text:'', ['placeholder' => 'Type here company name', 'class' => 'form-control']) }}
                                @if(isset($key->img) && !empty($key->img))
                                    <img src="{{URL::asset("/public/image/top_recruiters/".$key->img)}}" width="150" height="150">
                                @endif
                            </div>
                            @endforeach
                            @else
                                @for($i=0; $i<=3; $i++)
                                <div class="col-md-3 form-group">
                                    <input type="file" name="recruiters_img[]" class="form-control">
                                    {{ Form::text('top_recruiters[]', null, ['placeholder' => 'Type here company name', 'class' => 'form-control']) }}
                                </div>
                                @endfor
                            @endif

                        </div>

                        <div class="row form-group hidden">

                            <div class="col-md-12 form-group">
                                <h4>Expected Remuneration :-</h4>
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('expertt', 'Expert') }}
                                {{ Form::text('expertt', $career->expected_remuneration[0], ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('intermediate', 'Intermediate') }}
                                {{ Form::text('intermediate', $career->expected_remuneration[1], ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('beginner', 'Beginner') }}
                                {{ Form::text('beginner', $career->expected_remuneration[2], ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                            </div>

                        </div>
                        <div class="row form-group hidden">

                            <div class="col-md-12 form-group">
                                <h4>Special Traits :-</h4>
                            </div>
                            @for($i=0; $i<=2; $i++)
                            <div class="col-md-4 form-group">
                                {{ Form::text('traits_pointer[]', $career->traits_in_pointers[$i], ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                            </div>
                            @endfor

                        </div>
                        <div class="row form-group hidden">

                            <div class="col-md-12 form-group">
                                <h4>Famous Personalities :-</h4>
                            </div>
                            @if(!empty($career->famouse_personaliities))
                                 @foreach($career->famouse_personaliities as $key)
                                <div class="col-md-3 form-group">

                                    <input type="file" name="famous_img[]" class="form-control">
                                    <input type="hidden" name="fimg[]" value="{{@$key->famous_img}}">
                                    {{ Form::text('designation[]', @$key->designation, ['placeholder' => 'Type designation', 'class' => 'form-control']) }}
                                    @if(isset($key->famous_img) && $key->famous_img!=null)
                                    <img src="{{URL::asset("/public/image/famous_img/".$key->famous_img)}}" width="150" height="150">
                                    @endif
                                </div>
                                @endforeach 
                            @else
                                 @for($i=0; $i<=3; $i++)
                                <div class="col-md-3 form-group">
                                    <input type="file" name="famous_img[]" class="form-control">
                                    {{ Form::text('designation[]', null, ['placeholder' => 'Type designation', 'class' => 'form-control']) }}
                                </div>
                                @endfor
                            @endif

                        </div>
                        <div class="row form-group">

                           
                           <div class="col-md-12 form-group">
                                <h4>Future Prospects :-</h4>
                            </div>
                            <div class="col-md-12 form-group">
                                {{ Form::label('text', 'Future Prospects') }}
                                {{ Form::text('prospect', $career->prospect, ['placeholder' => 'Future Prospects', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group hidden">
                                {{ Form::label('graph', 'Upload graph') }}
                                <input type="file" name="graph" class="form-control">
                                @if(isset($career->lies_ahead->graph) && !empty($career->lies_ahead->graph))
                                <img src="{{URL::asset("/public/image/graph/".$career->lies_ahead->graph)}}" width="150" height="150">
                                @endif
                            </div>

                        </div>
                          <div class="row form-group ">
                            <div class="col-md-12 form-group">
                                <h4>Competencies needed for the job:-</h4>
                            </div>
                            @foreach($career->competencies as $value)
                            <div class="col-md-3 form-group">
                                {{ Form::text('competencies_title[]', $value->title, ['placeholder' => 'Title', 'class' => 'form-control']) }}
                                {{Form::textarea('competencies_desc[]',$value->description,['placeholder' => 'Description','class'=>'form-control', 'rows' => 4, 'cols' => 50])}}
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-12 form-group">
                                <h4>How I Get a job:-</h4>
                            </div>
                            @foreach($career->career_jobs as $value)
                            <div class="col-md-4">
                                 {{ Form::text('job_title[]', $value->title, ['placeholder' => 'Title', 'class' => 'form-control']) }}
                                {{Form::textarea('job_desc[]',$value->description,['class'=>'form-control ckeditor', 'rows' => 4, 'cols' => 50])}}
                                
                            </div>
                            @endforeach

                        </div>
                     
                        <div class="row form-group">
                            <div class="col-md-12 form-group">
                                <h4>Pros And Cons About Career  :-</h4>
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('pros', 'Pros') }}
                                {{Form::textarea('pros',@$career->pros,['class'=>'form-control ckeditor', 'rows' => 5, 'cols' => 40])}}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('cons', 'Cons') }}
                                {{Form::textarea('cons',@$career->cons,['class'=>'form-control ckeditor', 'rows' => 5, 'cols' => 40])}}
                            </div>
                        </div>
                       
                        <div class="row form-group hidden">

                            <div class="col-md-12 form-group">
                                <h4>GPTS Certified Colleges :-</h4>
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('text', 'Top colleges') }}
                                <select class="form-control chosen-select" multiple="multiple" name="top_college[]">
                                    @foreach($college as $key => $value)
                                    <option value="{{$key}}" @if(isset($career->top_colleges) && in_array($key, $career->top_colleges)) selected  @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                        
                        @endif
                        @if($career->type==1)
                        <div class="row form-group ">

                            <div class="col-md-12 form-group">
                                <h4>Do you know  :-</h4>
                            </div>
                            @foreach($career->do_you_know as $value)
                            <div class="col-md-3 form-group">
                                {{ Form::text('title_do[]', $value->title, ['placeholder' => 'Title', 'class' => 'form-control']) }}
                                {{Form::textarea('desc_do[]',$value->description,['placeholder' => 'Description','class'=>'form-control', 'rows' => 5, 'cols' => 40])}}
                            </div>
                            @endforeach

                        </div>
                        @endif
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




