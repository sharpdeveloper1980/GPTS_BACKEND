@extends('admin.layouts.app')

@section('title', 'Manage Customers')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Home Videos List</h1>
    </section>
    <section class="content">
        <div class="row">
          <div class="pull-right">
                {{ Form::open(['method' => 'get']) }}
                <div class="col-md-10" style="margin-bottom:10px;">
                    {{ Form::text('Search', null, ['placeholder' => 'Search User', 'class' => 'form-control']) }}
                </div>
                <div class="col-md-2">
                    {{ Form::submit('Search', ['class' => 'btn btn-default pull-right']) }}
                </div>

                {!! Form::close() !!}
            </div>
			 <div class="pull-left">
                
                <div class="col-md-4">
                <a href="{!! url('/admin/add-home-video'); !!}">{{ Form::button('Add New', ['class' => 'btn btn-warning']) }}</a>
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
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            @php $sno=1; @endphp
                            @foreach($videos as $row)
                            <tr>
                            	<td>{{$sno++}}</td>
                            	<td>{{ $row->name }}</td>
                            	<td>
                                    <a href="{{ url('/admin/viewhomevideo/'.$row->id)}}" title="Edit">
                                        <i class="fa fa-pencil-square-o fa-lg"></i>
                                    </a>&nbsp;&nbsp;&nbsp;
                                    <a href="{!! url('/admin/deletehomevideo'); !!}/{{@$row->id}}"  onclick = "if (!confirm('Are you sure, want to delete selected item?')) {
                                              return false;
                                          }"  title="Delete">
                                        <i class="fa fa-trash-o fa-lg" style="color:#dd4b39;"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection