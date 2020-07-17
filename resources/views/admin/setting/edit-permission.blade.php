@extends('admin.layouts.app')

@section('title', 'Admin - Edit Menu')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Permission
      </h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
			  <!-- general form elements -->
			  <div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Edit Permission</h3>
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
				{{ Form::model($userPermission, ['method' => 'post','url' => ['/admin/edit-permission', @$userPermission->id]]) }}
				{{csrf_field()}}
				 <div class="box-body">
					<div class="form-group">
						<ul>
						@foreach($allMenu as $menu)
							<li>
								<input type="checkbox" name="menu[]" value="{{$menu['menu_id']}}" @if(in_array($menu['menu_id'], $userPermission['menu']))checked="checked"@endif /><span>{{$menu['menu']}}</span>
								<ul>
									@foreach($menu['sub_menu'] as $submenu)
										<li>
											<input type="checkbox" name="submenu[]" value="{{$submenu['id']}}" @if(in_array($submenu['id'], $userPermission['sub_menu']))checked="checked"@endif /><span>{{$submenu['menu']}}</span>
										</li>
									@endforeach
								</ul>
							</li>
						@endforeach
						</ul>
					</div>
                                     <input type="hidden" name="role" value="{{@$userPermission->role}}"> 
<!--					<div class="form-group col-md-12">
						{{ Form::label('role', 'Role') }}<span class="required">*</span>
                                                
						{{ Form::select('role', array('' => 'Select User','1'=>'Super Admin','2'=>'Admin','4'=>'Editor','5'=>'Publisher'),@$userPermission->role,['class' => 'form-control'])}}
					</div>-->
					<div class="form-group col-md-12">
						{{ Form::label('Set Permission', 'Set Permission') }}<span class="required">*</span>
						&nbsp;&nbsp;<input type="checkbox" name="add" @if($userPermission->add=='Yes') checked='checked' @endif/> &nbsp;&nbsp;<span>Add</span>
						&nbsp;&nbsp;<input type="checkbox" name="edit" @if($userPermission->edit=='Yes') checked='checked' @endif /> &nbsp;&nbsp;<span>Edit</span>
						&nbsp;&nbsp;<input type="checkbox" name="delete" @if($userPermission->delete=='Yes') checked='checked' @endif /> &nbsp;&nbsp;<span>Delete</span>
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




