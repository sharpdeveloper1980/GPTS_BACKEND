@extends('admin.layouts.app')

@section('title', 'Edit Career video Library')

@section('content')

@include('admin.layouts.header')
<style>
    select.selectpicker { display:none; /* Prevent FOUC */}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Career video Library</h1>
    </section>
    <section class="content">   
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Career video Library</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/show-career-video/'); !!}/{{$career_id}}/{{$subcareer_id}}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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

                    {{ Form::model($careervideo, ['method' => 'post','url' => ['/admin/edit-career-video', @$careervideo->id] ,'files' => true]) }}
                    {{csrf_field()}}

                    <div class="box-body">
                        <div class="row form-group">
                            
                            <div class="col-md-4 form-group">
                                {{ Form::label('title', 'Title') }}<span class="required">*</span>
                                {{ Form::text('title',$careervideo->title , ['placeholder' => 'Video Title', 'class' => 'form-control ','required'=>'required']) }}
                            </div>
                            
                            <div class="col-md-4 form-group">
                                {{ Form::label('name', 'Name') }}<span class="required">*</span>
                                {{ Form::text('name', $careervideo->name, ['placeholder' => 'Video Name', 'class' => 'form-control ','required'=>'required']) }}
                                <input type="hidden" name="career_id" value="{{$careervideo->career_id}}">
                                <input type="hidden" name="type" value="{{$careervideo->type}}">
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('title', 'Designation') }}<span class="required">*</span>
                                {{ Form::text('designation',$careervideo->designation , ['placeholder' => 'Designation', 'class' => 'form-control ','required'=>'required']) }}
                            </div>
                            
                            <div class="col-md-6 form-group">
                                @if($careervideo->video_thumb!=null || $careervideo->video_thumb!='')
                                
                                
                                <div class="bg_img" style="background:url(https://s3.eu-west-1.amazonaws.com/gpts-portal/career-library/{{$careervideo->videotype}}/{{$careervideo->video_thumb}})"></div>
                                @endif
                                <input type="file" name="video_thumb" class="form-control imagefl" >
                                
                            </div>
                            <div class="col-md-6 form-group">
                                @if($careervideo->video!=null || $careervideo->video!='')
                                <video width="500" height="250" controls><source src="https://s3.eu-west-1.amazonaws.com/gpts-portal/career-library/{{$careervideo->videotype}}/{{$careervideo->video}}" type="video/mp4"></video>
                                @endif
                                <input type="file" name="video" class="form-control" id="fl">
                                
                            </div>
                              <div class="col-md-12 form-group">
                                {{ Form::label('about', 'Breif Description') }}<span class="required">*</span>
                                {{Form::textarea('about',@$careervideo->about,['class'=>'form-control', 'rows' => 4, 'cols' => 50, 'required'=>'required'])}}
                            </div>
                            <!--<div class="col-md-2 form-group">
                                {{ Form::label('Position', 'Position') }}<span class="required">*</span>
                                {{ Form::number('position',@$careervideo->position, ['placeholder' => 'Position', 'class' => 'form-control ','required'=>'required']) }}
                            </div>-->
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




