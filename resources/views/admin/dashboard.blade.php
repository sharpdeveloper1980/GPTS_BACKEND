@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Welcome {{ucfirst(Auth::user()->fullname)}}
            <!--<small>Blank example to the fixed layout</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">

        <div class="col-md-3 col-sm-6 col-xs-12">

          <div class="info-box">
                <span class="info-box-icon bg-aqua" style="padding-top:20px;">
                <i class="fa fa fa-group"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">Total Student</span>
                <span class="info-box-number">{{$totalStudent}}</span>
                </div>
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">

          <div class="info-box">
                <span class="info-box-icon bg-yellow" style="padding-top:20px;">
                <i class="fa fa-graduation-cap"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">TTE Students</span>
                <span class="info-box-number">{{$totalTTEStudent}}</span>
                </div>
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">

        <div class="info-box">
                <span class="info-box-icon bg-aqua background-green" style="padding-top:20px;">
                <i class="fa fa fa-building"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">Total School</span>
                <span class="info-box-number">{{$totalSchool}}</span>
                </div>
          </div>

        <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">

        <div class="info-box">
                <span class="info-box-icon bg-aqua background-red" style="padding-top:20px;">
                <i class="fa fa fa-university"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">Total Collage</span>
                <span class="info-box-number">0</span>
                </div>
          </div>

        <!-- /.info-box -->
        
        </div>
      
      </div>
      <div class="row">
        <div class="col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">Current CDAP Registered Students<div class="pull-right"><a href="{{Url::to('/admin/students')}}"><button class="btn btn-info btn-xs">View All</button></a></div></div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Email</th>	
								<th>Status</th>
                                <th>Action</th>
                            </tr>
                            <?php $i = 1; ?>
                            @if(isset($currentStudent) && !$currentStudent->isEmpty())
                            @foreach($currentStudent as $key => $data)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><a href="{!! url('/admin/studentview'); !!}/{{@$data->id}}">{{@$data->name}}</a></td>


                                <td>{{@$data->email}}</td>
                                <td>@if($data->status ==1) <span class="label label-success">Active</span>  @elseif($data->status ==0) <span class="label label-danger">Inactive</span> @endif</td>
                                <td><a href="{!! url('/admin/studentview/') !!}/{{@$data->id}}" title="Edit">
                                        <i class="fa fa-eye"></i>
                                    </a>&nbsp;&nbsp;&nbsp;

                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8">
                                    <h2 class="text-center">No Records!!</h2>
                                </td>
                            </tr>

                            @endif
                        </table>
                    </div>
                </div>
        </div>
        <div class="col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">Current TTE Students<div class="pull-right"><a href="{{Url::to('/admin/students/tte')}}"><button class="btn btn-info btn-xs">View All</button></a></div></div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Email</th>	
								<th>Status</th>
                                <th>Action</th>
                            </tr>
                            <?php $i = 1; ?>
                            @if(isset($tteResult) && !$tteResult->isEmpty())
                            @foreach($tteResult as $key => $data)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><a href="{!! url('/admin/studentview'); !!}/{{@$data->id}}">{{@$data->name}}</a></td>


                                <td>{{@$data->email}}</td>
                                <td>@if($data->status ==1) <span class="label label-success">Active</span>  @elseif($data->status ==0) <span class="label label-danger">Inactive</span> @endif</td>
                                <td><a href="{!! url('/admin/studentview'); !!}/{{@$data->id}}" title="Edit">
                                        <i class="fa fa-eye"></i>
                                    </a>&nbsp;&nbsp;&nbsp;

                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8">
                                    <h2 class="text-center">No Records!!</h2>
                                </td>
                            </tr>

                            @endif
                        </table>
                    </div>
                </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




