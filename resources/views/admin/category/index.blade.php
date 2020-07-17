@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Categories
      </h1>
    </section>
	<section class="content">
	<div class="row">
		<div class="pull-right">
				  {{ Form::open(['method' => 'get']) }}
				  <div class="col-md-8" style="margin-bottom:10px;">
					{{ Form::text('Search', null, ['placeholder' => 'Search Category', 'class' => 'form-control']) }}
					</div>
					<div class="col-md-4">
					{{ Form::submit('Search By Name', ['class' => 'btn btn-warning pull-right']) }}
					</div>
					
				   {!! Form::close() !!}
		</div>
	</div>
		<div class="row">
		<div class="col-md-4">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add New Category</h3>
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
			
            {{ Form::open(['url' => 'admin/addcategory', 'method' => 'post' ,'files' => true] ) }}
			{{csrf_field()}}
			 <div class="box-body">
				<div class="form-group">
				{{ Form::label('name', 'Name') }}<span class="required">*</span>
				{{ Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control title','onchange' => 'getmeta()']) }}
				
				</div>
				
				<div class="form-group">
				{{ Form::label('slug', 'Slug') }}
				{{ Form::text('slug', null, ['placeholder' => 'Slug', 'class' => 'form-control slug']) }}
				
				</div>
				<div class="form-group">
				{{ Form::label('Image', 'Image') }}
				{{ Form::file('img', ['placeholder' => 'Img', 'class' => 'form-control']) }}
				</div>
				<div class="form-group">
				{{ Form::label('description', 'Description') }}
				{{ Form::textarea('description', null, ['placeholder' => 'Description', 'class' => 'form-control']) }}
				</div>
                             <div class="form-group">
				{{ Form::label('Meta Description', 'Meta Description') }}
				{{ Form::textarea('meta_description', null, ['placeholder' => 'Meta Description', 'class' => 'form-control']) }}
				
				</div>
                             <div class="form-group">
				{{ Form::label('Meta Tags', 'Meta Tags') }}
				{{ Form::textarea('meta_tag', null, ['placeholder' => 'Meta Tags', 'class' => 'form-control meta_tag']) }}
				
				</div>
                               <div class="form-group">
				{{ Form::label('Meta Title', 'Meta Title') }}
				{{ Form::text('meta_h1', null, ['placeholder' => 'Meta Title', 'class' => 'form-control meta_h1']) }}
				
				</div>
			 </div>
			 
			 <div class="box-footer">
                {{ Form::submit('Add New Category', ['class' => 'btn btn-warning']) }}
              </div>
            {!! Form::close() !!}
			
          </div>
          <!-- /.box -->


        </div>
	
		<div class="col-md-8">

          <div class="box">
            <!-- /.box-header -->
			  
            <div class="box-body no-padding">
              <table class="table">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>@sortablelink('name')</th>
				  <th>Description</th>
                  <th style="width: 40px">Slug</th>
				  <th style="width: 40px">Action</th>
                </tr>
				<?php $i = 1;?>
                @if(!$category->isEmpty())
				@foreach($category as $key => $categoryData)
                <tr>
                  <td>{{$key+1}}</td>
                  <td><a href="{!! url('admin/show'); !!}/{{@$categoryData->id}}">{{@$categoryData->name}}</a></td>
                  <td>{{@$categoryData->description}}</td>
                  <td>{{@$categoryData->slug}}</td>
				  <td>
				  <a href="{!! url('admin/show'); !!}/{{@$categoryData->id}}" title="Edit">
				  <i class="fa fa-pencil" style="color:#00a65a;"></i>
				  </a>&nbsp;&nbsp;&nbsp;
				  <a href="{!! url('admin/deleteCategory'); !!}/{{@$categoryData->id}}"  onclick = "if (! confirm('Are you sure, want to delete selected item?')) { return false; }"  title="Delete">
				  <i class="fa fa-remove" style="color:#dd4b39;"></i>
				  </a>
				  </td>
                </tr>
				@endforeach
                                 @else
                            <tr>
                                <td colspan="8">
                                    <h2 class="text-center">No Record Found!!</h2>
                                </td>
                            </tr>

                            @endif
              </table>
            </div>

            <!-- /.box-body -->
          </div>
		  
		  {!! $category->appends(\Request::except('page'))->render() !!}

               
        </div>
		</div>
	</section> 
</div>
  <!-- /.content-wrapper -->
  <script>
    function getmeta(){
 var title =$('.title').val();
$(".meta_tag").val(title);
$(".meta_h1").val(title);



}
</script>
@include('admin.layouts.footer')

@endsection




