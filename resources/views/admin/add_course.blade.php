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
				  <h3 class="box-title">Sub-Stream</h3>
				  	<div class="pull-right">
						<a href="{!! url('admin/courses-listing'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
				{{ Form::open(['url' => '/admin/add-course', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
				{{csrf_field()}}
				<input type="hidden" name="course_id" value="{{$course[0]->id}}"/>

				 <div class="box-body"> 
				 	<div class="col-md-6">
						<div class="form-group">
							{{ Form::label('stream', 'Stream') }}<span class="required">*</span>
							<select name="stream" class="form-control" required="">
								<option value="">Select Stream</option>
								@foreach($stream AS $row)
								<option value="{{ $row->id }}" @if($course[0]->stream_id==$row->id) selected @endif>{{ $row->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							{{ Form::label('name', 'Name') }}<span class="required">*</span>
							<input type="text" name="name" class="form-control" value="{{ $course[0]->name }}" placeholder="Enter name" required="" />
						</div>
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