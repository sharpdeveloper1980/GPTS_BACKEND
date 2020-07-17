@extends('admin.layouts.app')

@section('title', 'Add Career Library')

@section('content')

@include('admin.layouts.header')
<style>
    select.selectpicker { display:none; /* Prevent FOUC */}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add <span class="text_Career">Career</span>  Library</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add <span class="text_Career">Career</span> Library</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/career'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
                    
                    {{ Form::open(['url' => '/admin/save-career', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
                    {{csrf_field()}}
                    
                    <div class="box-body">
                        <div class="row form-group">
                            
                            <div class="col-md-4 form-group">
                                <label><span class="text_Career">Career</span> Name</label><span class="required">*</span>
                                {{ Form::text('name', null, ['placeholder' => 'Name of Career', 'class' => 'form-control title','required'=>'required']) }}
                            </div>
                            
                            <div class="col-md-4 form-group">
                                {{ Form::label('Slug', 'Slug') }}<span class="required">*</span>
                                {{ Form::text('slug', null, ['placeholder' => 'Slug', 'class' => 'form-control slug','required'=>'required']) }}
                            </div>
                            
                            <div class="col-md-4 form-group">
                                {{ Form::label('Type', 'Career Type') }}<span class="required">*</span>
                                {{ Form::select('career_type', array(""=>"select","1"=>"Parent Career","2"=>"Sub Career"),@$_GET['type'], ['id'=>'cartype','onchange'=>'getform()','class' => 'form-control','required'=>'required']) }}
                            </div>
                        </div>
                        
                        <div class="row form-group cat">
                            <div class="col-md-3 form-group">
                                {{ Form::label('Type', 'Career TTE Unique Id') }}<span class="required">*</span>
                                {{ Form::select('tte_career_id', $TteIdList,'', ['class' => 'form-control ','required'=>'required']) }}
                            </div> 
                              <div class="col-md-3 form-group">
                                {{ Form::label('Edieo Cluster Thumbnail', 'Edieo Cluster Thumbnail') }}
                                <input type="file" name="edieo_thumb"  class="form-control imagefl">
                            </div>

                             <div class="col-md-3 form-group">
                                {{ Form::label('Edieo College Thumbnail', 'Edieo College Thumbnail') }}
                                <input type="file" name="edieo_cluster_thumb"  class="form-control imagefl">
                            </div>

                            
                            <div class="col-md-3 form-group">
                                {{ Form::label('industry expert', 'Industry Expert Video') }}
                                <input type="file" name="exp_video" id="fl" class="form-control ">
                            </div>
                          
                            <div class="col-md-3 form-group">
                                {{ Form::label('Video Thumbnail', 'Video Thumbnail') }}
                                <input type="file" name="video_thumb"  class="form-control imagefl">
                            </div>
                             <div class="col-md-3 form-group">
                                {{ Form::label('College Cluster Video', 'College Cluster Video') }}
                                <input type="file" name="cluster_video"  class="form-control" id="f1">
                            </div>
                        </div>
                        <div class="row form-group cat">
                            <div class="col-md-6 form-group">
                                {{ Form::label('Video title', 'Video Name') }}
                                {{ Form::text('video_title', null, ['placeholder' => 'Video Name', 'class' => 'form-control']) }}
                            </div> 
                            <div class="col-md-6 form-group">
                                {{ Form::label('Video Designation', 'Video Designation') }}
                                {{ Form::text('video_designation', null, ['placeholder' => 'Video Designation', 'class' => 'form-control']) }}
                            </div>
                        </div>
                        
                        <div class="row form-group cat">
                            <div class="col-md-3 form-group">
                                {{ Form::label('No. of Colleges', 'No. of Colleges') }}
                                {{ Form::number('college_no', null, ['placeholder' => 'No. of Colleges', 'class' => 'form-control']) }}
                            </div> 
                            <div class="col-md-3 form-group">
                                {{ Form::label('Undergraduate Programme', 'Undergraduate Programme') }}
                                {{ Form::number('under_programme', null, ['placeholder' => 'Undergraduate Programme', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-3 form-group">
                                {{ Form::label('Students Enrolled', 'Students Enrolled') }}
                                {{ Form::number('students_enrolled', null, ['placeholder' => 'Students Enrolled', 'class' => 'form-control']) }}
                            </div> 
                            <div class="col-md-3 form-group">
                                {{ Form::label('Average Fees', 'Average Fees') }}
                                {{ Form::text('average_fees', null, ['placeholder' => 'Average Fees', 'class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="row form-group cat">
                            <div class="col-md-8 form-group">
                                {{ Form::label('Quotes', 'Quotes') }}
                                {{ Form::text('quotes', null, ['placeholder' => 'Quotes', 'class' => 'form-control']) }}
                            </div> 
                            <div class="col-md-4 form-group">
                                {{ Form::label('Person Name', 'Person Name') }}
                                {{ Form::text('person_name', null, ['placeholder' => 'Quotes Person Name', 'class' => 'form-control']) }}
                            </div>
                        </div>
                        
                        <div class="row form-group">

                            <div class="col-md-3 form-group">
                                {{ Form::label('Cluster Image', 'Cluster Image') }}
                                <input type="file" name="cluster_image" class="form-control imagefl">
                            </div>
                            <div class="col-md-3 form-group">
                                {{ Form::label('Career Banner', 'Career Banner') }}
                                <input type="file" name="career_banner" class="form-control imagefl">
                            </div>
                            <div class="col-md-3 form-group">
                                {{ Form::label('logo', 'Career Icon') }}
                                <input type="file" name="career_icon" class="form-control imagefl">
                            </div>
                            <div class="col-md-3 form-group">
                                {{ Form::label('Career Image', 'Career Image') }}
                                <input type="file" name="career_image" class="form-control imagefl">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 form-group">
                                {{ Form::label('Footer Quote', 'Footer Quote') }}<span class="required">*</span>
                                {{ Form::text('banner_title', null, ['placeholder' => 'Footer Quote', 'class' => 'form-control ','required'=>'required']) }}
                            </div>
                        </div>
                        <div class="row form-group sub_cat">
                            <div class="col-md-6 form-group">
                                {{ Form::label('Type', 'Career List') }}<span class="required">*</span>
                                {{ Form::select('parent_id', $careerlist,@$_GET['career_id'], ['class' => 'form-control ']) }}                            
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Type', 'Beginning Minimum Salary') }}
                                {{ Form::text('salary', null, ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="row form-group sub_cat">
                            <div class="col-md-12 form-group">
                                {{ Form::label('career_ladder', 'Career Ladder') }}
                            </div>
                            @for($i=0; $i<=5; $i++)
                            <div class="col-md-2 form-group">
                                {{ Form::text('career_ladder[]', null, ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                            </div>
                            @endfor
                        </div>
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                {{ Form::label('about', 'About Career') }}<span class="required">*</span>
                                {{Form::textarea('about',null,['class'=>'form-control', 'rows' => 4, 'cols' => 50, 'required'=>'required'])}}
                            </div>

                        </div>

                        <div class="row form-group sub_cat">
                            <div class="col-md-12 form-group">
                                <h4>Area cover:-</h4>
                            </div>
                            @for($i=0; $i<=5; $i++)
                            <div class="col-md-2 form-group">
                                {{ Form::text('area_covers[]', null, ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                            </div>
                            @endfor
                        </div>
                        <div class="row form-group sub_cat">

                            <div class="col-md-12 form-group">
                                {{ Form::label('key psychology', 'key psychology') }}
                                {{Form::textarea('key_psychology',null,['class'=>'form-control', 'rows' => 4, 'cols' => 50])}}
                            </div>

                        </div>
                        <div class="row form-group sub_cat">
                            <div class="col-md-12 form-group">
                                <h4>Related Career:-</h4>
                            </div>
                            @for($i=0; $i<=3; $i++)
                            <div class="col-md-3 form-group">
                                {{ Form::text('related_title[]', null, ['placeholder' => 'Title', 'class' => 'form-control']) }}
                                {{Form::textarea('related_desc[]',null,['placeholder' => 'Description','class'=>'form-control', 'rows' => 4, 'cols' => 50])}}
                            </div>
                            @endfor
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

                        <div class="row form-group hidden">

                            <div class="col-md-12 form-group">
                                <h4>Top Recruiters :-</h4>
                            </div>
                            @for($i=0; $i<=3; $i++)
                            <div class="col-md-3 form-group">
                                <input type="file" name="recruiters_img[]" class="form-control">
                                {{ Form::text('top_recruiters[]', null, ['placeholder' => 'Type here company name', 'class' => 'form-control']) }}
                            </div>
                            @endfor

                        </div>

        
                        <div class="row form-group hidden">

                            <div class="col-md-12 form-group">
                                <h4>Special Traits :-</h4>
                            </div>
                            @for($i=0; $i<=2; $i++)
                            <div class="col-md-4 form-group">
                                {{ Form::text('traits_pointer[]', null, ['placeholder' => 'Type here', 'class' => 'form-control']) }}
                            </div>
                            @endfor

                        </div>
                        <div class="row form-group hidden">

                            <div class="col-md-12 form-group">
                                <h4>Famous Personalities :-</h4>
                            </div>
                            @for($i=0; $i<=3; $i++)
                            <div class="col-md-3 form-group">
                                <input type="file" name="famous_img[]" class="form-control">
                                {{ Form::text('designation[]', null, ['placeholder' => 'Type designation', 'class' => 'form-control']) }}
                            </div>
                            @endfor

                        </div>
                        <div class="row form-group sub_cat">

                            <div class="col-md-12 form-group">
                                <h4>Future Prospects :-</h4>
                            </div>
                            <div class="col-md-12 form-group">
                                {{ Form::label('text', 'Future Prospects') }}
                                {{ Form::text('prospect', null, ['placeholder' => 'Future Prospects', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group hidden">
                                {{ Form::label('graph', 'Upload graph') }}
                                <input type="file" name="graph" class="form-control">
                            </div>

                        </div>
                        <div class="row form-group sub_cat">
                            <div class="col-md-12 form-group">
                                <h4>Competencies needed for the job:-</h4>
                            </div>
                            @for($i=0; $i<=3; $i++)
                            <div class="col-md-3 form-group">
                                {{ Form::text('competencies_title[]', null, ['placeholder' => 'Title', 'class' => 'form-control']) }}
                                {{Form::textarea('competencies_desc[]',null,['placeholder' => 'Description','class'=>'form-control', 'rows' => 4, 'cols' => 50])}}
                            </div>
                            @endfor
                        </div>
                        <div class="row form-group sub_cat">
                            <div class="col-md-12 form-group">
                                <h4>How I Get a job:-</h4>
                            </div>
                            @for($i=0; $i<=2; $i++)
                            <div class="col-md-4">
                               {{ Form::text('job_title[]', null, ['placeholder' => 'Title', 'class' => 'form-control']) }}
                                {{Form::textarea('job_desc[]',null,['placeholder' => 'Description','class'=>'form-control ckeditor', 'rows' => 4, 'cols' => 50])}}            
                            </div>
                            @endfor
                   
                        </div>
                        <div class="row form-group sub_cat">
                            <div class="col-md-12 form-group">
                                <h4>Pros And Cons About <span class="text_Career">Career</span>  :-</h4>
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('pros', 'Pros') }}
                                {{Form::textarea('pros',null,['class'=>'form-control ckeditor', 'rows' => 5, 'cols' => 40])}}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('cons', 'Cons') }}
                                {{Form::textarea('cons',null,['class'=>'form-control ckeditor', 'rows' => 5, 'cols' => 40])}}
                            </div>
                        </div>
                        <div class="row form-group cat">

                            <div class="col-md-12 form-group">
                                <h4>Do you know  :-</h4>
                            </div>
                            @for($i=0; $i<=3; $i++)
                            <div class="col-md-3 form-group">
                                {{ Form::text('title_do[]', null, ['placeholder' => 'Title', 'class' => 'form-control']) }}
                                {{Form::textarea('desc_do[]',null,['placeholder' => 'Description','class'=>'form-control', 'rows' => 5, 'cols' => 40])}}
                            </div>
                            @endfor

                        </div>
                        <div class="row form-group hidden">                         
                            <div class="col-md-6 form-group">
                                <h4>GPTS Certified Colleges :-</h4>
                                {{ Form::label('text', 'Top colleges') }}
                                <select class="form-control chosen-select" multiple="multiple" name="top_college[]">
                                    @foreach($college as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
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



@include('admin.layouts.footer')

@endsection




