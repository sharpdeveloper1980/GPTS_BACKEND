@extends('admin.layouts.app')

@section('title', 'Career')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       
        <h1>{{$careername}} career video list</h1>
    </section>
    <section class="content">
        <div class="row">

            <div class="pull-left">

                <div class="col-md-4">
                    <a href="{!! url('/admin/add-career-video'); !!}/{{$subcareer_id}}?career_id={{$career_id}}">{{ Form::button('Add New', ['class' => 'btn btn-warning']) }}</a>
                </div>
                
            </div>
             <div class="pull-right">
                 <div class="col-md-4">
            <a href="{!! url('/admin/edit-sub-career'); !!}/{{$subcareer_id}}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
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
                                <th>Type</th>
                                <th>Title</th>
                                <th>Name</th>
                                <th>Priority Video</th>
                                @if(Auth::user()->usertype==11||Auth::user()->usertype==12):
                                <th>Status</th>
                                @endif
                                <th>Action</th>
                            </tr>
                            <?php $i = 1; ?>
                            @if(!$careervideo->isEmpty())
                            @foreach($careervideo as $key => $careerData)
                            <?php
                            $type='';
                            if($careerData->type==1){
                                $type = 'Expert';
                            }else if($careerData->type==2){
                                $type = 'Intermediate';
                            }else if($careerData->type==3){
                                $type = 'Beginner';
                            }
                            ?>
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$type}}</td>
                                <td>{{$careerData->title}}</td>
                                <td>{{$careerData->name}}</td>
                                <td><input type="radio" name="pvideo" <?php if($careerData->priority_video == 1){echo 'checked';}?> onclick="changeVideoPriority(<?=$careerData->id?>)"/></td>
                                @if(Auth::user()->usertype==11||Auth::user()->usertype==12):
                                <td>
                                <select onchange="changeVideoStatus({{@$careerData->id}}, this)"  name="status">
                                        <option value="1" <?php if (@$careerData->status == 1) echo 'selected'; ?>>Publish</option>
                                        <option value="0" <?php if (@$careerData->status == 0) echo 'selected'; ?>>UnPublish</option>
                                </select>
                                </td>
                                @endif
                                <td> 
                                    <a href="{!! url('/admin/edit-career-video'); !!}/{{$career_id}}/{{@$careerData->id}}/{{@$subcareer_id}}" title="Edit">
                                        <i class="fa fa-pencil-square-o fa-lg"></i>
                                    </a>&nbsp;&nbsp;&nbsp;
                                    <a href="{!! url('/admin/delete-career-video'); !!}/{{@$careerData->type}}/{{@$careerData->video}}/{{@$careerData->video_thumb}}/{{@$careerData->id}}"  onclick = "if (!confirm('Are you sure, want to delete selected item?')) {
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
              
            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




