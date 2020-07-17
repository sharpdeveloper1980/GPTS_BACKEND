@extends('admin.layouts.app')

@section('title', 'View/Edit User')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         User : {{$user->fullname}}
      </h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
			  <!-- general form elements -->
			  <div class="box box-primary">
				<div class="box-header with-border">
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
				
				{{ Form::model($user, ['method' => 'post','url' => ['/admin/edituser', @$user->id] ,'files' => true, 'enctype'=>'multipart/form-data']) }}
				{{csrf_field()}}
				<div class="box-body"> 
					<div class="form-group col-md-6">
						{{ Form::label('name', 'Name') }}<span class="required">*</span>
						{{ Form::text('name', @$user->name, ['placeholder' => 'First Name', 'class' => 'form-control','required'=>'require']) }}
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('email', 'Email') }}<span class="required">*</span>
						{{ Form::email('email', @$user->email, ['placeholder' => 'Email', 'class' => 'form-control','required'=>'required','maxlength' => 255, 'readonly'=>'readonly']) }}
					</div>	
					<div class="form-group col-md-6">
						{{ Form::label('contact', 'Phone No') }}<span class="required">*</span>
						{{ Form::text('contact', @$user->contact, ['placeholder' => 'Phone No', 'class' => 'form-control','required'=>'required','maxlength' => 12]) }}
					</div>	
					<div class="form-group col-md-6">
						{{ Form::label('role', 'Role') }}<span class="required">*</span>
						{{ Form::select('role', @$usertypelist ,@$user->role,['class' => 'form-control'])}}
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




