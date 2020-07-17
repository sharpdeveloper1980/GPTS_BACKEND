@extends('admin.layouts.app')

@section('title', 'Edieo')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edieo List</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="pull-right">
                {{ Form::open(['method' => 'get']) }}
                <div class="col-md-10" style="margin-bottom:10px;">
                    {{ Form::text('Search', null, ['placeholder' => 'Search Career', 'class' => 'form-control']) }}
                </div>
                <div class="col-md-2">
                    {{ Form::submit('Search', ['class' => 'btn btn-default pull-right']) }}
                </div>

                {!! Form::close() !!}
            </div>
            <div class="pull-left">

                <div class="col-md-4">
                    <a href="{!! url('/admin/add-edieo-video'); !!}">{{ Form::button('Add New', ['class' => 'btn btn-warning']) }}</a>
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
                                <th>@sortablelink('title', 'Title')</th>
                                <th>Type</th>
                                <th>Banner Video</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <?php $i = 1; ?>
                            @if(!$edieo->isEmpty())
                            @foreach($edieo as $key => $data)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$data->title}}</td>
                                <td>{{ucwords($data->type)}}</td>
                                 <td><?php if($data->priority_video == 1){echo 'Yes';}?>
                                 </td>
                                <td>{{$data->position}}</td>
                                <td>
                                    <label for="status-{{$i}}" class="switch">
                                        <input name="status" id="status-{{$i}}" class="status" type="checkbox" value="1" data-id="{{@$data->id}}" data-type="Edieo" @if($data->status == 1) checked="checked" @endif>
                                               <span class="slider round"></span>
                                    </label>
                                </td>
                                <td> 
                                    <a href="{!! url('/admin/edit-edieo'); !!}/{{@$data->id}}" title="Edit">
                                        <i class="fa fa-pencil-square-o fa-lg"></i>
                                    </a>&nbsp;&nbsp;&nbsp;
                                    <a href="{!! url('/admin/delete-edieo'); !!}/{{@$data->id}}"  onclick = "if (!confirm('Are you sure, want to delete selected item?')) {
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
                {!! $edieo->appends(\Request::except('page'))->render() !!}
            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




