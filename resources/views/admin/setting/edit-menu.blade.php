@extends('admin.layouts.app')

@section('title', 'Admin - Edit Menu')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Menu
      </h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
			  <!-- general form elements -->
			  <div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Edit Menu</h3>
				  <div class="pull-right">
					<a href="{!! url('/admin/menu'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
				{{ Form::model($menu, ['method' => 'post','url' => ['/admin/edit-menu', @$menu->id]]) }}
				{{csrf_field()}}
				 <div class="box-body">
					<div class="form-group">
					{{ Form::label('menu', 'Menu') }}<span class="required">*</span>
					{{ Form::text('menu',$menu->menu , ['placeholder' => 'Menu', 'class' => 'form-control','maxlength' => 100,'required'=>'required']) }}
					</div>
					<div class="form-group">
					{{ Form::label('parent', 'Parent Menu') }}
					<select class="form-control m-bot15" name="pmenu">
					<option value="0">Select Parent Menu</option>

					   @if($pmenu->count() > 0)
					  @foreach($pmenu as $key)
					   <option value="{{$key->id}}" <?php if($menu->parent == $key->id) echo 'selected'; ?>>{{$key->menu}}</option>
					  @endForeach
					  @else
					   No Record Found
						@endif   
					</select>
					</div>
					<div class="form-group">
					{{ Form::label('link', 'Link') }}<span class="required">*</span>
					{{ Form::text('link', $menu->link, ['placeholder' => 'Link', 'class' => 'form-control','maxlength' => 100]) }}
					</div>
					<div class="form-group">
					{{ Form::label('icon', 'Icon') }}<span class="required">*</span>
					{{ Form::text('icon', $menu->icon, ['placeholder' => 'Icon', 'class' => 'form-control','maxlength' => 100,'required'=>'required']) }}
					</div>
					<div class="form-group">
					{{ Form::label('position', 'Position') }}<span class="required">*</span>
					{{ Form::text('position', $menu->position, ['placeholder' => 'Position', 'class' => 'form-control','maxlength' => 100,'required'=>'required']) }}
					</div>
				 </div>
				 <div class="box-footer text-right">
					{{ Form::submit('Save', ['class' => 'btn btn-warning']) }}
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




