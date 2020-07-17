@extends('admin.layouts.app')

@section('title', 'Set Permission')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Permission
      </h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
			  <!-- general form elements -->
			  <div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Add Permission</h3>
				  <div class="pull-right">
					<a href="{!! url('/admin/user-permission'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
				{{ Form::open(['url' => '/admin/store-permission', 'method' => 'post','files' => true]) }}
				{{csrf_field()}}
				 <div class="box-body">
					<div class="form-group">
						<ul>
						@foreach($allMenu as $menu)
							<li>
								<input type="checkbox" name="menu[]" value="{{$menu['menu_id']}}"  /><span>{{$menu['menu']}}</span>
								<ul>
									@foreach($menu['sub_menu'] as $submenu)
										<li>
											<input type="checkbox" name="submenu[]" value="{{$submenu['id']}}"/><span>{{$submenu['menu']}}</span>
										</li>
									@endforeach
								</ul>
							</li>
						@endforeach
						</ul>
					</div>
					<div class="form-group col-md-12">
						{{ Form::label('role', 'Role') }}<span class="required">*</span>
						{{ Form::select('role', @$usertypelist,'',['class' => 'form-control'])}}
					</div>
					<div class="form-group col-md-12">
						{{ Form::label('Set Permission', 'Set Permission') }}<span class="required">*</span>
						&nbsp;&nbsp;<input type="checkbox" name="add" /> &nbsp;&nbsp;<span>Add</span>
						&nbsp;&nbsp;<input type="checkbox" name="edit" /> &nbsp;&nbsp;<span>Edit</span>
						&nbsp;&nbsp;<input type="checkbox" name="delete" /> &nbsp;&nbsp;<span>Delete</span>
					</div>
				 </div>
				 <div class="box-footer text-right">
					{{ Form::submit('Add New', ['class' => 'btn btn-warning']) }}
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




