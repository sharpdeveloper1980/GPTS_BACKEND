@extends('admin.layouts.app')

@section('title', 'Edit University')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit University</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit University</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/university-list'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
                    {{ Form::model($user, ['method' => 'post','url' => ['/admin/edit-college', @$user->id] ,'files' => true]) }}
                    
                    {{csrf_field()}}
                    <div class="box-body">
                        <!--Basic Info Start-->
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                <h4>Basic Information :-</h4>
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('collageType', 'University Type') }}<span class="required">*</span>
                                {{ Form::select('university_type', @$collageType,@$user['college']->university_affiliated,['class' => 'form-control chosen-select'])}}

                            </div>
                            
                            <div class="col-md-6 form-group">
                                {{ Form::label('name', 'Name of University') }}<span class="required">*</span>
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
                                {{ Form::label('Mobile No', 'Mobile No.') }}
                                {{ Form::text('mobile_no', @$user['college']->phone_no, ['placeholder' => 'Mobile Number', 'class' => 'form-control']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Landline No.', 'Landline No') }}
                                {{ Form::text('landline_no', @$user['college']->landline_no, ['placeholder' => 'Landline Number', 'class' => 'form-control']) }}
                            </div>
                            <div class=" col-md-6 form-group">
                                {{ Form::label('Alternative No.', 'Alternative No') }}
                                {{ Form::text('alternative_no', @$user['college']->alternative_no, ['placeholder' => 'Alternative Number', 'class' => 'form-control']) }}
                            </div>
                           
                            <div class="col-md-12 form-group">
                                {{ Form::label('Addresss', 'Address') }}<span class="required">*</span>
                                {{Form::textarea('address',@$user['college']->address,['class'=>'form-control', 'rows' => 8, 'cols' => 40])}}
                            </div>

                        </div>
                        <!--Basic Info End-->

                        <!--About Institute Start-->
                        <div class="row form-group">

                            <div class="col-md-12 form-group">
                                <h4>About University :-</h4>
                            </div>


                             <div class="col-md-6 form-group">
                                {{ Form::label('Logo.', 'Logo') }}<br>
                                @if($user['college']->logo!='')
                                <img src="{{URL::asset("/public/image/".$user['college']->logo)}}" width="200" height="200">
                                @else
                                <img src="https://via.placeholder.com/200" width="200" height="200" >
                                @endif
                                <input type="file" name="logo" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('Cover Image.', 'Cover Image') }}<br>
                                @if($user['college']->cover_logo!='')
                                <img src="{{URL::asset("/public/image/".$user['college']->cover_logo)}}" width="200" height="200" >
                                @else
                                <img src="https://via.placeholder.com/200" width="200" height="200" >
                                @endif
                                <input type="file" name="cover_img" class="form-control">
                            </div>



                            <div class="col-md-12 form-group">
                                {{ Form::label('About the Institute', 'About the Institute') }}
                                {{Form::textarea('about',@$user['college']->about,['class'=>'form-control', 'rows' => 8, 'cols' => 40])}}
                            </div>




                            <div class="col-md-12 form-group">
                                {{ Form::label('About the University', 'About the University') }}
                                {{Form::textarea('about',null,['class'=>'form-control', 'rows' => 8, 'cols' => 40])}}
                            </div>

                        </div>

                        <!--About Institute End-->

                        <!--Popular Alumni Start-->
                        <div class="row">
                             <div class="col-md-12 form-group">

                                <h4>Message from Head of Institute :-</h4>
                                @if($user['college']->head_inst_img!='')
                                <img src="{{URL::asset("/public/image/".$user['college']->head_inst_img)}}" width="200" height="200">
                                @else
                                <img src="https://via.placeholder.com/200" width="200" height="200" >
                                @endif
                                <input type="file" name="head_inst_img" class="form-control">

                                {{Form::textarea('head_inst_msg',@$user['college']->head_inst_msg,['class'=>'form-control','placeholder'=>'Please Input some Message here' ,'rows' => 5, 'cols' => 40])}}



                            </div>
                        </div>
                        <!--Popular Alumni End-->


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




