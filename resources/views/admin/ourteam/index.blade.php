@extends('admin.layouts.app')

@section('title', 'Team')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Team List</h1>
        <a href="{!! url('/admin/add-team'); !!}">{{ Form::button('Add New', ['class' => 'btn btn-warning']) }}</a>
    </section>
    <section class="content">
        <div class="row">
              <div class="pull-left">
                <div class="col-md-2">
                    <a href="{{Url('/admin/team-list/all')}}" title="All Students" class="btn btn-info">All</a>
                </div>
                <div class="col-md-3" style="margin-right:20px;">
                    <a href="{{Url('/admin/team-list/1')}}" title="Active Students" class="btn btn-info">Leadership</a>
                </div>
                <div class="col-md-3" >
                    <a href="{{Url('/admin/team-list/2')}}" title="Inactive Students" class="btn btn-info">Team</a>
                </div>
          
        </div>
            <div class="pull-right">
                {{ Form::open(['method' => 'get']) }}
                <div class="col-md-10" style="margin-bottom:10px;">
                    {{ Form::text('Search', null, ['placeholder' => 'Search team by name', 'class' => 'form-control']) }}
                </div>
                <div class="col-md-2">
                    {{ Form::submit('Search', ['class' => 'btn btn-default pull-right']) }}
                </div>

                {!! Form::close() !!}
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
                                <th>Designation</th>                               
                                <th>Action</th>
                            </tr>
                            <?php $i = 1; ?>
                            @if(!$teamlist->isEmpty())
                            @foreach($teamlist as $key => $teamData)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$teamData->name}}</td>
                                <td>{{$teamData->designation}}</td>
                                <td>
                                    <label for="status-{{$i}}" class="switch">
                                        <input name="status" id="status-{{$i}}" class="status" type="checkbox" value="1" data-id="{{$teamData->id}}" data-type="Team" @if($teamData->status == 1) checked="checked" @endif>
                                               <span class="slider round"></span>
                                    </label>
                                </td>
                                <td> 
                                    <a href="{!! url('/admin/edit-team'); !!}/{{$teamData->id}}" title="Edit">
                                        <i class="fa fa-pencil-square-o fa-lg"></i>
                                    </a>&nbsp;&nbsp;&nbsp;
                                    <a href="{!! url('/admin/delete-team'); !!}/{{$teamData->id}}"  onclick = "if (!confirm('Are you sure, want to delete selected item?')) {
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
                {!! $teamlist->appends(\Request::except('page'))->render() !!}
            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




