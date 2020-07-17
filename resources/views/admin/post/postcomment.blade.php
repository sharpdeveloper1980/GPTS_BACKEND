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
	 <div class="pull-right">
                <a href="{!! url('/postcomment'); !!}">{{ Form::button('Back', ['class' => 'btn btn-primary']) }}</a>
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
				  <th>Comment</th>
                                   <th>Author</th>
                                   <th>Comment By</th>
                                 
                  <th>created_at</th>
                  <th>Approved</th>
				  <th style="width: 40px">Action</th>
                </tr>
				<?php $i = 1;?>
                @if(!$postComment->isEmpty())
				@foreach($postComment as $key => $postCommentData)
                                
                <tr>
                  <td>{{$key+1}}</td>
                  <td><a href="{!! url('/editPostComment'); !!}/{{@$postCommentData->id}}">{{@$postCommentData->title}}</a></td>
                  <td>{{@$postCommentData->comment}}</td>
                  <td>{{@$postCommentData->authorname}}</td>
                   <td>{{@$postCommentData->name}}</td>
                  <td>{{@$postCommentData->created_at}}</td>
                @if($postCommentData->status!=0)
                     <td><a href="{!! url('/PostCommentapproved'); !!}/{{@$postCommentData->post_id}}/{{@$postCommentData->id}}/0"  onclick = "if (! confirm('Are you sure, want to approved selected item?')) { return false; }"  title="Approved">
				<button type="button" class="btn btn-danger">Not Approved</button>
				  </a>
                  </td> 
           
                
                  @else
                  <td>
                      <a href="{!! url('/PostCommentapproved'); !!}/{{@$postCommentData->post_id}}/{{@$postCommentData->id}}/1"  onclick = "if (! confirm('Are you sure,you want to unapproved selected item?')) { return false; }"  title="Unapproved">
                     <button type="button" class="btn btn-success">Approved</button>
                      </a>
                      </td>
                  @endif
				  <td>
				  <a href="{!! url('/editPostComment'); !!}/{{@$postCommentData->id}}" title="Edit">
				  <i class="fa fa-pencil" style="color:#00a65a;"></i>
				  </a>&nbsp;&nbsp;&nbsp;
				  <a href="{!! url('/deletePostComment'); !!}/{{@$postCommentData->post_id}}/{{@$postCommentData->id}}"  onclick = "if (! confirm('Are you sure, want to delete selected item?')) { return false; }"  title="Delete">
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
	

               
        </div>
		</div>
	</section> 
</div>
  <!-- /.content-wrapper -->
  
@include('admin.layouts.footer')

@endsection




