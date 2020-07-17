@extends('admin.layouts.app')

@section('title', 'Edit Gallery')

@section('content')

@include('admin.layouts.header')
<style>
    .close{
            position: relative;
 
    font-size: 20px;
    float: right;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{@$collegename->name}} Gallery</h1>
    </section>
    <section class="content">	
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Gallery</h3>
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
                    
                     {{ Form::open(['url' => '/admin/save-gallery', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row form-group">

                            <div class="col-md-6 form-group">
                                <input type="file" name="gallery_img[]" class="form-control"  required>
                                <input type="hidden" name="college_id" value="{{@$college_id}}">
                            </div>
                            <div class="col-md-3 form-group">
                                {{ Form::submit('Add New', ['class' => 'btn btn-warning']) }}
                            </div>
                        </div>
                        <div class="row form-group gallerylist">
                           
                              @if($gallery->count() > 0)
                            @foreach($gallery as $index => $value)
                            <div class="col-md-3 form-group">
                              @if($value->img!='')
                                <a href="{!! url('/admin/delete-gallery'); !!}/{{$value->id}}" class="close">
									<i class="fa fa-window-close" aria-hidden="true"></i>
								</a>
                                <img src="{{URL::asset("/public/image/gallery/".$value->img)}}" width="100%" height="200" >
                              @endif
                                
                            </div>
                            @endForeach
                            @endif
                            
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




