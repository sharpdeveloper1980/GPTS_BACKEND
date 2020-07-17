@extends('admin.layouts.app')

@section('title', 'Career')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Career List</h1>
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
                    <a href="{!! url('/admin/add-career'); !!}">{{ Form::button('Add New', ['class' => 'btn btn-warning']) }}</a>
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
                                <!--<th>View Videos</th>-->
                                <th>View Sub Career</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <?php $i = 1; ?>
                            @if(!$career->isEmpty())
                            @foreach($career as $key => $careerData)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$careerData->name}}</td>
                                <!--<td><a href="{!! url('/admin/edit-scholarship'); !!}/{{@$careerData->id}}"><i class="fa fa-eye fa-lg"></i></a></td>-->
                         
                                <td>
                                    @if($careerData->total_subcareer > 0)   
                                    <a href="{!! url('/admin/edit-sub-career'); !!}/{{@$careerData->id}}"><i class="fa fa-eye fa-lg"></i></a>
                                    @else
                                    <a href="{!! url('/admin/add-career'); !!}?career_id={{@$careerData->id}}&type=2" class="text-danger">No sub career added</a>
                                    @endif
                                </td>
                                <td>{{date('d/m/Y', strtotime($careerData->created_at))}}</td>

                                <td>
                                    <label for="status-{{$i}}" class="switch">
                                        <input name="status" id="status-{{$i}}" class="status" type="checkbox" value="1" data-id="{{@$careerData->id}}" data-type="Career" @if($careerData->status == 1) checked="checked" @endif>
                                               <span class="slider round"></span>
                                    </label>
                                </td>
                                <td> 
                                    <a href="{!! url('/admin/show-career'); !!}/{{@$careerData->id}}" title="Edit">
                                        <i class="fa fa-pencil-square-o fa-lg"></i>
                                    </a>&nbsp;&nbsp;&nbsp;
                                    <a href="{!! url('/admin/delete-career'); !!}/{{@$careerData->type}}/{{@$careerData->id}}"  onclick = "if (!confirm('Are you sure, want to delete selected item?')) {
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
                {!! $career->appends(\Request::except('page'))->render() !!}
            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




