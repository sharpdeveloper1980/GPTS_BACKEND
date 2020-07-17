@extends('admin.layouts.app')

@section('title', 'Manage Student')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    </section>
    <section class="content">
        <div class="row">

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
                                <th>Question</th>
                                <th>Video</th>
                                <th>Action</th> 
                            </tr>
                            <?php $i = 1; ?>
                            @if(!$sop->isEmpty())
                            @foreach($sop as $key => $sopData)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$sopData->question}}</td> 
                                <td><a href="{{Url('/')}}/public/sop/{{$sopData['sopAnswer']->filename}}">View</a></td> 
                                <td> <a href="{!! url('/admin/delete-sop-video'); !!}/{{$sopData['sopAnswer']->filename}}/{{@$sopData->id}}"  onclick = "if (!confirm('Are you sure, want to delete selected item?')) {
                                                return false;
                                            }"  title="Delete">
                                        <i class="fa fa-trash-o fa-lg" style="color:#dd4b39;"></i>
                                    </a></td>
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
                
            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




