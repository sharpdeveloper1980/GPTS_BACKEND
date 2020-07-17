@extends('admin.layouts.app')

@section('title', 'User Permission')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User Permission
        </h1>
    </section>
    <section class="content">

        <div class="row">
            <!--<div class="pull-right col-md-5">
                {{ Form::open(['method' => 'get']) }}
                <div class="col-md-10" style="margin-bottom:10px;">
                    {{ Form::text('Search', null, ['placeholder' => 'Search by page Title', 'class' => 'form-control']) }}
                </div>
                <div class="col-md-2">
                    {{ Form::submit('Search', ['class' => 'btn btn-default pull-right']) }}
                </div>

                {!! Form::close() !!}
            </div>-->
            <div class="pull-left">
                
                <div class="col-md-4">
                <a href="{!! url('/admin/add-user-permission'); !!}">{{ Form::button('Add New', ['class' => 'btn btn-warning']) }}</a>
                </div>
            </div>

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
                                <th>User Type</th>
                                <th>Add</th>
								<th>Edit</th>
								<th>Delete</th>
								<th>Created By</th>
                                <th>Action</th>
                            </tr>
							@php
							$i = 1
							@endphp
                            @if(!$userPermission->isEmpty())
                            @foreach($userPermission as $key => $data)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{@$data->user_type}}</a></td>
                                <td>{{@$data->add}}</td>
                                <td>{{@$data->edit}}</td>
                                <td>{{@$data->delete}}</td>
                                <td></td>
                                <td>
                                    <a href="{!! url('/admin/showpermission'); !!}/{{@$data->id}}" title="Edit">
                                        <i class="fa fa-pencil-square-o fa-lg"></i>
                                    </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="{!! url('/admin/delete-permission'); !!}/{{@$data->id}}"  onclick = "if (!confirm('Are you sure, want to delete selected item?')) {
                                              return false;
                                          }"  title="Delete">
                                        <i class="fa fa-trash-o fa-lg" style="color:#dd4b39;"></i>
                                    </a>
                                </td>
                            </tr>
							@php
							$i++;
							@endphp
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

                {!! $userPermission->appends(\Request::except('user_type'))->render() !!}


            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




