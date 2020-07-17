@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Post
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="pull-right">
                {{ Form::open(['method' => 'get']) }}
                <div class="col-md-8" style="margin-bottom:10px;">
                    {{ Form::text('Search', null, ['placeholder' => 'Search Post', 'class' => 'form-control']) }}
                </div>
                <div class="col-md-4">
                    {{ Form::submit('Search By Title', ['class' => 'btn btn-warning pull-right']) }}
                </div>

                {!! Form::close() !!}
            </div>
            <div class="pull-left">

                <div class="col-md-4">
                    <a href="{!! url('admin/addpost'); !!}">{{ Form::button('Add New Post', ['class' => 'btn btn-warning']) }}</a>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">

                <div class="box">
                    <!-- /.box-header -->

                    <div class="box-body no-padding">
                        <table class="table">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@sortablelink('title')</th>
                                <th>Category</th>
                                <th style="width: 40px">Position</th>
                                <th style="width: 40px">created_at</th>
                                @if(Auth::user()->usertype==11||Auth::user()->usertype==12):
                                <th style="width: 40px">Status</th>
                                @endif
                                <th style="width: 40px">Action</th>
                            </tr>
                            <?php $i = 1; ?>
                            @if(!$post->isEmpty())
                            @foreach($post as $key => $postData)

                            <tr>
                                <td>{{$key+1}}</td>
                                <td><a href="{!! url('admin/editpost'); !!}/{{@$postData->id}}">{{@$postData->title}}</a></td>
                                <td><a href="{!! url('admin/show'); !!}/{{@$postData->cat_id}}">{{@$postData->cat_name}}</a></td>
                                <td>{{@$postData->position}}</td>
                                <td>{{@$postData->publish_date}}</td>
                                @if(Auth::user()->usertype==11||Auth::user()->usertype==12):
                                <td><select onchange="changepoststatus({{@$postData->id}}, this)"  name="status">
                                        <option value="1" <?php if ($postData->status == 1) echo 'selected'; ?>>Publish</option>
                                        <option value="0" <?php if ($postData->status == 0) echo 'selected'; ?>>UnPublish</option>
                                    </select>
                                </td>
                                @endif
                                <td>
                                    <a href="{!! url('admin/editpost'); !!}/{{@$postData->id}}" title="Edit">
                                        <i class="fa fa-pencil" style="color:#00a65a;"></i>
                                    </a>&nbsp;&nbsp;&nbsp;
                                    <a href="{!! url('admin/deletePost'); !!}/{{@$postData->id}}"  onclick = "if (! confirm('Are you sure, want to delete selected item?')) { return false; }"  title="Delete">
                                        <i class="fa fa-remove" style="color:#dd4b39;"></i>
                                    </a>
                                </td>
                            </tr>
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

                {!! $post->appends(\Request::except('page'))->render() !!}


            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




