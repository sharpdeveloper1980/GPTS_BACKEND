@extends('admin.layouts.app')

@section('title', 'Manage Customers')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>College List</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="pull-right">
                {{ Form::open(['method' => 'get']) }}
                <div class="col-md-10" style="margin-bottom:10px;">
                    {{ Form::text('Search', null, ['placeholder' => 'Search College', 'class' => 'form-control']) }}
                </div>
                <div class="col-md-2">
                    {{ Form::submit('Search', ['class' => 'btn btn-default pull-right']) }}
                </div>

                {!! Form::close() !!}
            </div>
            <div class="pull-left">

                <div class="col-md-4">
                    <a href="{!! url('/admin/add-college'); !!}">{{ Form::button('Add New', ['class' => 'btn btn-warning']) }}</a>
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
                                <th>Email ID</th>
                                <th>Contact</th>
                                <th>Gallery Pics</th>
                                <th>Scholarship</th>
                                <th>Course</th>
                                <th>Nano Classes</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <?php $i = 1; ?>
                            @if(!$user->isEmpty())
                            @foreach($user as $key => $userData)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><a href="{!! url('/admin/edit-college'); !!}/{{@$userData->user_id}}">{{@$userData->collegename}}</a></td>
                                <td>{{$userData->email}}</td>

                                <td>{{$userData->contact}}</td>
                                @if($userData->total_gallery > 0)
                                <td><a href="{!! url('/admin/edit-gallery'); !!}/{{@$userData->user_id}}"><i class="fa fa-eye fa-lg"></i></a></td>
                                @else
                                <td><a href="{!! url('/admin/edit-gallery'); !!}/{{@$userData->user_id}}" class="text-danger">No gallery added</a></td>
                                @endif
                                @if($userData->total_scholarship > 0)
                                <td><a href="{!! url('/admin/edit-scholarship'); !!}/{{@$userData->user_id}}"><i class="fa fa-eye fa-lg"></i></a></td>
                                @else
                                <td><a href="{!! url('/admin/edit-scholarship'); !!}/{{@$userData->user_id}}" class="text-danger">No scholarship added</a></td>
                                @endif
                                @if($userData->total_course > 0)
                                <td><a href="{!! url('/admin/view-course'); !!}/{{@$userData->user_id}}"><i class="fa fa-eye fa-lg"></i></a></td>
                                @else
                                <td><a href="{!! url('/admin/add-courses'); !!}" class="text-danger">No course added</a></td>
                                @endif
                                <td>
                                <a href="{!! url('/admin/nano-class-video-list'); !!}/{{@$userData->user_id}}" class="{{ $userData->total_nano_classes > 0 ? '' : 'text-danger' }}">
                                    @if($userData->total_nano_classes > 0)
                                    <i class="fa fa-eye fa-lg"></i>
                                    @else No class added @endif
                                </a>
                                </td>

                                <td>
                                    <label for="status-{{$i}}" class="switch">
                                        <input name="status" id="status-{{$i}}" class="status" type="checkbox" value="1" data-id="{{@$userData->user_id}}" data-type="User" @if($userData->status == 1) checked="checked" @endif>
                                               <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>
                                    <a href="{!! url('/admin/edit-college'); !!}/{{@$userData->user_id}}" title="Edit">
                                        <i class="fa fa-pencil-square-o fa-lg"></i>
                                    </a>&nbsp;&nbsp;&nbsp;
                                    <a href="{!! url('/admin/deletecollege'); !!}/{{@$userData->user_id}}"  onclick = "if (!confirm('Are you sure, want to delete selected item?')) {
                                                return false;
                                            }"  title="Delete">
                                        <i class="fa fa-trash-o fa-lg" style="color:#dd4b39;"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $i++ ?>
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
                {!! $user->appends(\Request::except('page'))->render() !!}
            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




