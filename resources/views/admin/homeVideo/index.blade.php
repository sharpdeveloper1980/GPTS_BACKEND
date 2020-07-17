@extends('admin.layouts.app')

@section('title', 'Static Page Video List')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Static Page Video List</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="pull-right">
                {{ Form::open(['method' => 'get']) }}
                <div class="col-md-10" style="margin-bottom:10px;">
                    {{ Form::text('Search', null, ['placeholder' => 'Search video with title name', 'class' => 'form-control']) }}
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
                                <th>@sortablelink('title', 'Title')</th>
                                <!--<th>View Videos</th>-->
                                <th>Name</th>
                                <th>Type</th>
                               
                                <th>Action</th>
                            </tr>
                            <?php $i = 1; ?>
                            @if(!$staticvideo->isEmpty())
                            @foreach($staticvideo as $key => $staticvideoData)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$staticvideoData->title}}</td>
                                <td>{{$staticvideoData->name}}</td>
                                <td><?php if($staticvideoData->type==1){ 
                                        echo 'Home';
                                    }else if($staticvideoData->type==2){
                                        echo'CDAP';
                                    }else if($staticvideoData->type==3){
                                        echo'I am a Student';
                                    }else if($staticvideoData->type==4){
                                        echo 'Nano Teaser';
                                    }else if($staticvideoData->type==5)
                                    { echo 'Careere Teaser';
                                    }else if($staticvideoData->type==6){
                                     echo 'College Teaser';
                                    }else{
                                        echo 'GLI Certifactions';
                                    }?>
                                        
                                    </td>
                               
                                <td> 
                                    <a href="{!! url('/admin/edit-static-page-videos'); !!}/{{$staticvideoData->id}}/{{$staticvideoData->type}}" title="Edit">
                                        <i class="fa fa-pencil-square-o fa-lg"></i>
                                    </a>&nbsp;&nbsp;&nbsp;
                                   
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
                {!! $staticvideo->appends(\Request::except('page'))->render() !!}
            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




