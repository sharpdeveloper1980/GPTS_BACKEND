@extends('admin.layouts.app')

@section('title', 'Manage User')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
	<section class="content">	
		<div class="row">
			<div class="col-md-12">
			  <!-- general form elements -->
			  <div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Home Video</h3>
				  	<div class="pull-right">
						<a href="{!! url('home-page-videos'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
				{{ Form::open(['url' => '/admin/add-home-video', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
				{{csrf_field()}}
				<input type="hidden" name="video_id" value="{{$video[0]->id}}"/>

				 <div class="box-body"> 
					<div class="form-group col-md-6">
						{{ Form::label('name', 'Name') }}<span class="required">*</span>
						<input type="text" name="name" placeholder="Name of video" class="form-control" required="" value="{{ $video[0]->name }}" />
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('poster', 'Poster') }}<span class="required">*</span> @if($video[0]->poster) <a href="https://gpts-portal.s3.eu-west-1.amazonaws.com/home-video/new/{{$video[0]->poster}}" target="_blank">(View)</a> @endif
						<input type="file" name="poster" class="form-control" value=""/>
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('thumbnail', 'Thumbnail') }} @if($video[0]->thumbnail) <a href="https://gpts-portal.s3.eu-west-1.amazonaws.com/home-video/new/{{$video[0]->thumbnail}}" target="_blank">(View)</a> @endif
						<input type="file" name="thumbnail" class="form-control" value=""/>
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('video', 'Video') }}<span class="required">*</span> @if($video[0]->video) <a href="https://gpts-portal.s3.eu-west-1.amazonaws.com/home-video/new/{{$video[0]->video}}" target="_blank">(View)</a> @endif
						<input type="file" name="video" class="form-control" value=""/>
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('background', 'Is Background Video?') }}
						<input type="checkbox" name="bgvideo" value="1" @if($video[0]->isbg==1) checked @endif/>
					</div>

					<div class="col-md-12">
						<div class="box-footer text-right">
							{{ Form::submit('Save', ['class' => 'btn btn-warning']) }}
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