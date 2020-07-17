@extends('admin.layouts.app')

@section('title', 'Edit Edieo Video')

@section('content')

@include('admin.layouts.header')
<style>
    select.selectpicker { display:none; /* Prevent FOUC */}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Edieo Video</h1>
    </section>
    <section class="content">   
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Edieo Video</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/edieo-video-list'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    @if (\Session::get('error'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach (\Session::get('error') as $error)
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

                    {{ Form::model($edieo, ['method' => 'post','url' => ['/admin/edit-edieo', @$edieo->id] ,'files' => true]) }}
                    {{csrf_field()}}

                    <div class="box-body">
                        <div class="row form-group">
     
                            <div class="col-md-3 form-group">
                                {{ Form::label('title', 'Title') }}<span class="required">*</span>
                                {{ Form::text('title', $edieo->title, ['placeholder' => 'Video Title', 'class' => 'form-control','required'=>'required']) }}
                            </div>
                            
                            <div class="col-md-3 form-group">
                                {{ Form::label('type', 'Type') }}<span class="required">*</span>
                                <select name="type" class="form-control">
                                    <option value="career" <?php if($edieo->type == 'career'){echo 'selected';} ?>>Career</option>
                                    <option value="country" <?php if($edieo->type == 'country'){echo 'selected';} ?>>Country</option>
                                    <option value="college" <?php if($edieo->type == 'college'){echo 'selected';} ?>>College</option>
                                    <option value="must-know" <?php if($edieo->type == 'must-know'){echo 'selected';} ?>>Must Know</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                {{ Form::label('career', 'Career') }}<span class="required">*</span>
                                <select name="career" class="form-control">
                                    <option value="career" <?php if($edieo->title == 'career'){echo 'selected';} ?>>Career</option>
                                    <option value="country" <?php if($edieo->title == 'country'){echo 'selected';} ?>>Country</option>
                                    <option value="college" <?php if($edieo->title == 'college'){echo 'selected';} ?>>College</option>
                                    <option value="must-know" <?php if($edieo->title == 'must-know'){echo 'selected';} ?>>Must Know</option>
                                </select>
                            </div>
                            
                            <div class="col-md-3 form-group">
                                {{ Form::label('sub_career', 'Sub Career') }}<span class="required">*</span>
                                <select name="sub_career" class="form-control" required="">
                                    <option value="">Select Sub Career</option>
                                    @foreach($sub_career as $sub)
                                    <option value="{{ $sub->slug }}" <?php if($edieo->slug == $sub->slug){echo 'selected';} ?>>{{ $sub->slug }}</option>
                                    @endforeach
                                </select>
                            </div>


                            @if($edieo->logo!=null || $edieo->logo!='')   
                            
                            <div class="col-md-2 form-group">
                                {{ Form::label('logo', 'Logo / Flag') }}
                                <input type="file" name="logo" class="form-control">
                            </div>

                                                                                         
                            <div class="bg_img col-md-2 form-group" style="background:url(https://s3.eu-west-1.amazonaws.com/gpts-portal/edieo/logo/{{$edieo->logo}})">
                            </div>
                            
                            @endif

                            <div class="col-md-4 form-group">
                                {{ Form::label('ttecareer', 'TTE Careers') }}
                                <select name="career" class="selectpicker form-control" data-live-search="true">
                                    <option value="">Select Career</option>
                                    @foreach($tte_careers as $row)
                                    <option value="{{ $row['tte_career_id'] }}" <?php if($edieo->career == $row['tte_career_id']){ echo 'selected'; }?>>{{ $row['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 form-group">
                                {{ Form::label('Career Icon', 'Career Icon') }}
                                <input type="file" name="cluster_image" class="form-control">
                                @if($edieo->cluster_image!=null || $edieo->cluster_image!='')                                                                
                                <div class="bg_img" style="width:100%;height:20%;background:url(https://s3.eu-west-1.amazonaws.com/gpts-portal/edieo/thumb/{{$edieo->cluster_image}})">
                                </div>
                                @endif
                            </div>

                            <div class="col-md-4 form-group">
                                {{ Form::label('Video Thumbnail', 'Video Thumbnail') }}
                                <input type="file" name="video_thumb" class="form-control">
                                @if($edieo->video_thumb!=null || $edieo->video_thumb!='')                                                                
                                <div class="bg_img" style="width:100%;height:20%;background:url(https://s3.eu-west-1.amazonaws.com/gpts-portal/edieo/thumb/{{$edieo->video_thumb}})">
                                </div>
                                @endif
                            </div>
                           

                            <div class="col-md-4 form-group">
                                {{ Form::label('name', 'Video') }}
                                <input type="file" name="video" class="form-control">
                                @if($edieo->video!=null || $edieo->video!='')
                                <video width="300" height="150" controls><source src="https://s3.eu-west-1.amazonaws.com/gpts-portal/edieo/video/{{$edieo->video}}" type="video/mp4"></video>
                                @endif
                            </div>

                            <div class="col-md-4 form-group">
                                {{ Form::label('name', 'Banner Video') }}
                                <input type="file" name="banner_video" class="form-control">
                                @if($edieo->banner_video!=null || $edieo->banner_video!='')
                                <video width="300" height="150" controls><source src="https://s3.eu-west-1.amazonaws.com/gpts-portal/edieo/video/{{$edieo->banner_video}}" type="video/mp4"></video>
                                @endif
                            </div>

                            <div class="col-md-8 form-group">
                                {{ Form::label('descp', 'Description') }}<span class="required">*</span>
                                <textarea required class="form-control" name="descp">{{$edieo->descp}}</textarea>
                            </div>

                             <div class="col-md-4 form-group">
                                {{ Form::label('Banner', 'Banner') }}
                                <br/>
                                <input type="checkbox" name="priority_video" <?php if($edieo->priority_video == 1){echo 'checked';}?>>
                            </div>

                             <div class="col-md-4 form-group">
                                {{ Form::label('position', 'Position') }}
                                {{ Form::number('position', $edieo->position, ['placeholder' => 'Position', 'class' => 'form-control','required'=>'required']) }}
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




