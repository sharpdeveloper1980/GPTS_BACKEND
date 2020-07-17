@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Post Comment
        </h1>
    </section>
    <section class="content">
        
        <div class="row">

            <div class="col-md-12">

                <div class="box">
                    <!-- /.box-header -->

                    <div class="box-body no-padding">
                        <table class="table">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>@sortablelink('Post title')</th>
                                <th>Author</th>
                                <th>Total count</th>
                              
                                <th style="width: 40px">Action</th>
                            </tr>
                            <?php $i = 1; ?>
                            @if(!$postComment->isEmpty())
                            @foreach($postComment as $key => $postCommentData)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><a href="{!! url('admin/viewcomment'); !!}/{{@$postCommentData->post_id}}">{{@$postCommentData->title}}</a></td>
                                <td>{{@$postCommentData->authorname}}</td>
                                <td>{{@$postCommentData->totalcomment}}</td>
                               
                                <td>
                                    <a href="{!! url('admin/viewcomment'); !!}/{{@$postCommentData->post_id}}" title="View">
                                        <i class="fa fa-eye" style="color:#00a65a;"></i>
                                    </a>&nbsp;&nbsp;&nbsp;				  
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

              


            </div>
        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




