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
				  <h3 class="box-title">Add New University Video</h3>
				  	<div class="pull-right">
						<a href="{!! url('admin/university-listing'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
				{{ Form::open(['url' => '/admin/add-university-video','id'=>'videoform', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
				{{csrf_field()}}
				<input type="hidden" name="video_id" value="{{$video[0]->id}}"/>

				<div class="box-body"> 
					<div class="form-group col-md-6">
						{{ Form::label('cluster', 'Cluster') }}<span class="required">*</span>
						<select name="cluster" class="form-control">
							<option value="">Select Cluster</option>
							@foreach($cluster AS $row)
							<option value="{{ $row->id }}" @if($video[0]->cluster_id==$row->id) selected @endif>{{ $row->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('name', 'Name') }}<span class="required">*</span>
						<input type="text" name="name" placeholder="Name of video" class="form-control" required="" value="{{ $video[0]->name }}" />
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('poster', 'Poster') }} @if($video[0]->poster) <a href="https://gpts-portal.s3.eu-west-1.amazonaws.com/university/{{$video[0]->poster}}" target="_blank">(View)</a> @endif
						<input type="file" name="poster" class="form-control" value=""/>
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('thumbnail', 'Thumbnail') }}<span class="required">*</span> @if($video[0]->thumbnail) <a href="https://gpts-portal.s3.eu-west-1.amazonaws.com/university/{{$video[0]->thumbnail}}" target="_blank">(View)</a> @endif
						<input type="file" name="thumbnail" class="form-control" value=""/>
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('video', 'Video') }}<span class="required">*</span> @if($video[0]->video) <a href="https://gpts-portal.s3.eu-west-1.amazonaws.com/university/{{$video[0]->video}}" target="_blank">(View)</a> @endif
						<input type="file" name="video" class="form-control" value=""/>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>
<script type="text/javascript">
	$.validator.addMethod('size', function (value, element, param) {
        if (value && element && param) {
            megabyte = element.files[0].size / 1024 / 1024;
            return this.optional(element) || (megabyte <= param);
        } else {
            return true;
        }
    }, 'File size must be less than {0} MB');

	// validate signup form on keyup and submit
	var validator=$("#videoform").validate({
		rules: {
			cluster: "required",
			name: "required",
			poster: {
				extension:"jpg|png|jpeg",
                size:1
			},
			thumbnail: {
				extension:"jpg|png|jpeg",
                size:1
			},
			video: {
				extension:"mp4",
                size:200
			}
		}
	});	
</script>

@include('admin.layouts.footer')

@endsection