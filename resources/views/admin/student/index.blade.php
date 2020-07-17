@extends('admin.layouts.app')

@section('title', 'Manage Student')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@if($type == 'active' || $type == 'inactive' || $type == 'all' || $type == 'tte'){{ucwords($type)}}@endif Students List ({{$count}})</h1>
    </section>
    <section class="content">
        <div class="row">
        @if($type == 'active' || $type == 'inactive' || $type == 'all' || $type == 'tte')
        <div class="pull-left">
                <div class="col-md-2" style="margin-right:60px;">
                    <a href="{{Url('/admin/students')}}" title="All Students" class="btn btn-info">All Students</a>
                </div>
                <!-- <div class="col-md-2" style="margin-right:20px;">
                    <a href="{{Url('/admin/students/active')}}" title="Active Students" class="btn btn-info">Active Students</a>
                </div>
                <div class="col-md-2" >
                    <a href="{{Url('/admin/students/inactive')}}" title="Inactive Students" class="btn btn-info">Inactive Students</a>
                </div> -->
                <div class="col-md-2">
                    <a href="{{Url('/admin/students/tte')}}" title="TTE Students" class="btn btn-info">TTE Students</a>
                </div>
        </div>
        
        @endif
          <div class="pull-right">
                {{ Form::open(['method' => 'get']) }}
                <div class="col-md-5" style="margin-bottom:10px;">
                    {{ Form::text('Search',@$_REQUEST['Search'], ['placeholder' => 'Search by student name', 'class' => 'form-control']) }}
                </div>
                <div class="col-md-5" style="margin-bottom:10px;">
                    <select name="school_cmb" class="form-control">
                        <option value="">Select School</option>
                        @foreach($schools_list AS $row)
                            <option value="{{ $row->id }}" <?php if(@$_REQUEST['school_cmb']==$row->id){ echo 'selected';}?>>{{ $row->name }}</option>
                        @endforeach
                    </select>
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
                                <th>Email ID</th>
                                <th>School</th>
                                <th>Contact</th>
                                <th>SOP Question Answer</th>
                                <th>SOP Video</th>
                                <th>Registered At</th>
                                <th>Status</th>
                                @if(isset($type) && $type == 'tte')<th style="width:12%;">Downlod Report</th>@endif
                                 <th>View</th> 
                            </tr>
                            <?php $i = 1; ?>
                            @if($students)
                            @foreach($students as $key => $userData)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><a href="{!! url('/admin/studentview'); !!}/{{ @$userData['id'] }}">{{ $userData['name'] }}</a></td>
                                <td>{{ $userData['email'] }}</td>
                                <td>{{ $userData['school_name'] }}</td>
                                <td>{{$userData['contact']}}</td>
                                <td>
                                    @if($userData['sop_question'] > 0)   
                                    <a href="{!! url('/admin/edit-user-sop'); !!}/text/{{ @$userData['id'] }}"><i class="fa fa-eye fa-lg"></i></a>
                                    @else
                                   Not Added !!
                                    @endif
                                </td>
                                <td>
                                    @if($userData['sop_video'] > 0)   
                                    <a href="{!! url('/admin/edit-user-sop'); !!}/video/{{ @$userData['id'] }}"><i class="fa fa-eye fa-lg"></i></a>
                                    @else
                                   Not Added !!
                                    @endif
                                </td>
                                <td>{{ date('d/m/Y', strtotime($userData['created_at'])) }}</td>
                                <td>
                                    <label for="status-{{$i}}" class="switch">
                                        <input name="status" id="status-{{$i}}" class="status" type="checkbox" value="1" data-id="{{ @$userData['id'] }}" data-type="User" @if($userData['status'] == 1) checked="checked" @endif>
                                               <span class="slider round"></span>
                                    </label>
                                </td>
                                @if(isset($type) && $type == 'tte')
                                    <td class="text-center">
                                        @if(!empty($userData['pdfreport']))
                                        <a href="{{ $userData['pdfreport'] }}" download target="_blank">
                                            <i class="fa fa-download"></i>
                                        </a>
                                        @endif
                                    </td>
                                @endif
                                 <td><a href="{!! url('/admin/studentview/') !!}/{{ @$userData['id'] }}"><i class="fa fa-eye"></i></a></td>
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

                {!! $students_paginate->appends(\Request::except('page'))->render() !!}

            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




