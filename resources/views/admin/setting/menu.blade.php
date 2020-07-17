@extends('admin.layouts.app')

@section('title', 'Admin - Menu')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Menu
        </h1>
    </section>
    <section class="content">

        <div class="row">
            <div class="pull-right">
                {{ Form::open(['method' => 'get']) }}
                <div class="col-md-8" style="margin-bottom:10px;">
                    {{ Form::text('Search', null, ['placeholder' => 'Search', 'class' => 'form-control']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::submit('Search By Title ', ['class' => 'btn btn-primary pull-right']) }}
                </div>

                {!! Form::close() !!}
            </div>
            <div class="pull-left">
                
                <div class="col-md-4">
                <a href="{!! url('/admin/add-menu'); !!}">{{ Form::button('Add New', ['class' => 'btn btn-success']) }}</a>
                </div>
            </div>

            <div class="col-md-12">

                <div class="box">
                    <!-- /.box-header -->

                    <div class="box-body no-padding">
                        <table class="table">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@sortablelink('title')</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            @php
							$i = 1
							@endphp
                            @if(!$menulist->isEmpty())
                            @foreach($menulist as $key => $data)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><a href="{!! url('/admin/show-menu'); !!}/{{@$data->id}}">{{@$data->menu}}</a></td>
                                <td>
									<label for="status-{{$i}}" class="switch">
									  <input name="status" id="status-{{$i}}" class="status" type="checkbox" value="1" data-id="{{@$data->id}}" data-type="Menu" @if($data->status == 1) checked="checked" @endif>
									  <span class="slider round"></span>
									</label>
								</td>
								<td>
                                    <a href="{!! url('/admin/show-menu'); !!}/{{@$data->id}}" title="Edit">
                                        <i class="fa fa-pencil" style="color:#00a65a;"></i>
                                    </a>&nbsp;&nbsp;&nbsp;
                                    <a href="{!! url('/admin/delete-menu'); !!}/{{@$data->id}}"  onclick = "if (!confirm('Are you sure, want to delete selected item?')) {
                                              return false;
                                          }"  title="Delete">
                                        <i class="fa fa-remove" style="color:#dd4b39;"></i>
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
                                    <h2 class="text-center">No Record Found!!</h2>
                                </td>
                            </tr>

                            @endif
                        </table>
                    </div>

                    <!-- /.box-body -->
                </div>

                {!! $menulist->appends(\Request::except('pagetitle'))->render() !!}


            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




