@extends('admin.layouts.app')

@section('title', 'Manage User')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Add User</h1>
    </section>
	<section class="content">	
		<div class="row">
			<div class="col-md-12">
			  <!-- general form elements -->
			  <div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Add New User</h3>
				  <div class="pull-right">
					<a href="{!! url('/admin/user'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
				{{ Form::open(['url' => '/admin/save-user', 'method' => 'post', 'enctype'=>'multipart/form-data']) }}
				{{csrf_field()}}
				 <div class="box-body"> 
					<div class="form-group col-md-6">
						{{ Form::label('fullname', 'Name') }}<span class="required">*</span>
						{{ Form::text('fullname', null, ['placeholder' => 'Name', 'class' => 'form-control','required'=>'require']) }}
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('email', 'Email') }}<span class="required">*</span>
						{{ Form::email('email', null, ['placeholder' => 'Email', 'class' => 'form-control','required'=>'required','maxlength' => 255]) }}
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('contact_no', 'Phone No') }}<span class="required">*</span>
						{{ Form::text('contact_no', null, ['placeholder' => 'Phone No', 'class' => 'form-control','required'=>'required','maxlength' => 12]) }}
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('role', 'Role') }}<span class="required">*</span>
						{{ Form::select('role', @$usertypelist,'',['class' => 'form-control'])}}
                        <input type="hidden" name="status" value="1">
					</div>
					<!--div class="form-group col-md-6">
						{{ Form::label('status', 'Status') }}<span class="required">*</span>
						{{ Form::select('status', array('1'=>'Approved','2'=>'Pending','3'=>'Blocked'),'1',['class' => 'form-control'])}}
					</div-->
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
  <!-- /.content-wrapper -->
  
@include('admin.layouts.footer')

@endsection




