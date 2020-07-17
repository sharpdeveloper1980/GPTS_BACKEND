@extends('admin.layouts.app')

@section('title', 'Manage Customers')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{$collegename->name}} Course List</h1>
    </section>
    <section class="content">
        <div class="row">
          <div class="pull-right">
                {{ Form::open(['method' => 'get']) }}
                <div class="col-md-10" style="margin-bottom:10px;">
                    {{ Form::text('Search', null, ['placeholder' => 'Search Course', 'class' => 'form-control']) }}
                </div>
                <div class="col-md-2">
                    {{ Form::submit('Search', ['class' => 'btn btn-default pull-right']) }}
                </div>

                {!! Form::close() !!}
            </div>
			 <div class="pull-left">
                
                <div class="col-md-4">
                <a href="{!! url('/admin/add-courses'); !!}">{{ Form::button('Add New', ['class' => 'btn btn-warning']) }}</a>
                </div>
            </div>
        </div>
        <div class="row">
			
            <div class="col-md-12">
				@if (\Session::get('success'))
					<div class="alert alert-success">
						<p>{{ \Session::get('success') }}</p>
					</div>
				@endif 	
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@sortablelink('name', 'Name')</th>
                                <th>Duration</th>
                                <th>Deadline</th>
                                <th>Action</th>
                            </tr>
                            <?php $i = 1; ?>
                            @if(!$course->isEmpty())
                            @foreach($course as $key => $courseData)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><a href="{!! url('/admin/edit-course'); !!}/{{@$courseData->id}}">{{@$courseData->name}}</a></td>
                                <td>{{$courseData->duration}}</td>                               
                                <td>{{$courseData->deadline}}</td>
                                
                                <td>
                                    <a href="{!! url('/admin/edit-course'); !!}/{{@$courseData->id}}" title="Edit">
                                        <i class="fa fa-pencil-square-o fa-lg"></i>
                                    </a>&nbsp;&nbsp;&nbsp;
                                    <a href="{!! url('/admin/delete-course'); !!}/{{@$courseData->id}}"  onclick = "if (!confirm('Are you sure, want to delete selected item?')) {
                                              return false;
                                          }"  title="Delete">
                                        <i class="fa fa-trash-o fa-lg" style="color:#dd4b39;"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8">
                                    <h4 class="text-center">No Record Found!!</h4>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                {!! $course->appends(\Request::except('page'))->render() !!}
            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




