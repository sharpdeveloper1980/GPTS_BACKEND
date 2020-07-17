@extends('admin.layouts.app')

@section('title', 'Edit Sop')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         SOP : {{ucwords($result->sop_type)}}
      </h1>
    </section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
			  <!-- general form elements -->
			  <div class="box box-primary">
				<!-- <div class="box-header with-border">
					<div class="pull-right">
						<a href="{!! url('/admin/user'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
					</div>
				</div> -->
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
				
				{{ Form::model($result, ['method' => 'post','url' => ['/admin/editsop', @$result->id] ,'files' => true]) }}
				{{csrf_field()}}
				<div class="box-body"> 
					<div class="form-group col-md-12">
						{{ Form::label('Sop Question', 'Question for '.$result->sop_type.' sop') }}<span class="required">*</span>
						{{ Form::textarea('question', @$result->question, ['placeholder' => 'First Name', 'class' => 'form-control','required'=>'require']) }}
					</div>						
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




