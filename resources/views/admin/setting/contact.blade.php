@extends('admin.layouts.app')

@section('title', 'User Permission')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Contact List
        </h1>
    </section>
    <section class="content">

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
                                <th>Email</th>
								<th>Contact</th>
								<th>Message</th>
								<th>Date</th>
                            </tr>
							@php
							$i = 1
							@endphp
                            @if(!$query->isEmpty())
                            @foreach($query as $key => $data)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{@$data->name}}</a></td>
                                <td>{{@$data->email}}</td>
                                <td>{{@$data->contact}}</td>
                                <td width="50%"><p class="comment more">{{$data->message, 0, 50}}</p></td>
                                <td>{{date('d-m-Y', strtotime($data->created_at))}}</td>
                               
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

                {!! $query->appends(\Request::except('page'))->render() !!}


            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




