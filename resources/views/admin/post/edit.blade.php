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
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Post</h3>
                        <div class="pull-right">
                            <a href="{!! url('/admin/post'); !!}">{{ Form::button('Back', ['class' => 'btn btn-default']) }}</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if (\Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ \Session::get('success') }}</p>
                    </div>
                    @endif 

                    {{ Form::model($post, ['method' => 'post','url' => ['admin/updatepost', @$post->id] ,'files' => true]) }}
                    {{csrf_field()}}
                    <div class="box-body">

                        <div class="form-group">
                            {{ Form::label('Category', 'Category') }}<span class="required">*</span>
                            {{ Form::select('category', $list['category'], @$post->category,[ 'class' => 'form-control my_select_box'])}}
                        </div>

                        <div class="form-group">
                            {{ Form::label('title', 'Title') }}<span class="required">*</span>
                            {{ Form::text('title', null, ['placeholder' => 'Title', 'class' => 'form-control title','onchange' => 'getmeta()']) }}
                        </div>
                        @if(!empty($list['postlist']))
                        <div class="form-group">
                            {{ Form::label('Related Post', 'Related Post') }}
                         

                            {{ Form::select('related_post[]', $list['postlist'], @$relatedpostlist,[ 'class' => 'form-control my_select_box' ,'multiple'])}}
                        </div>
                          @endif
                        <div class="form-group">
                            {{ Form::label('description', 'Description') }}
                            {{ Form::textarea('description', null, ['placeholder' => 'Description', 'class' => 'form-control ckeditor', 'id' => 'editor1']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('Image', 'Image') }}
                            @if(@$post->image!='')
                            <div class="img-wrap">
                                <a href="{!! url('admin/deleteimage'); !!}/{{@$post->image}}/{{@$post->id}}"  onclick = "if (!confirm('Are you sure, want to delete this image?')) {
                                             return false;
                                         }"  title="Delete">
                                    <span class="close">&times;</span>
                                </a>
                                <img src="https://s3.eu-west-1.amazonaws.com/gpts-portal/blog/post/{{@$post->image}}" width="250" height="250" alt="Post Image">
                            </div>                                                       
                            @endif
                            {{ Form::file('image', ['placeholder' => 'Image', 'class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('slug', 'Slug') }}
                            {{ Form::text('slug', @$post->slug, ['placeholder' => 'Slug', 'class' => 'form-control']) }}
                        </div>
                          <div class="form-group">
                            {{ Form::label('Short Description', 'Short Description') }}
                            {{ Form::textarea('short_desc', @$post->short_desc, ['placeholder' => 'Short Description', 'class' => 'form-control','required'=>'required']) }}

                        </div>
                        <div class="form-group">
                            {{ Form::label('Meta Description', 'Meta Description') }}
                            {{ Form::textarea('meta_description', @$post->meta_description, ['placeholder' => 'Meta Description', 'class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('Meta Tags', 'Meta Tags') }}
                            {{ Form::textarea('meta_tag', @$post->meta_tag, ['placeholder' => 'Meta Tags', 'class' => 'form-control meta_tag']) }}

                        </div>
                        <div class="form-group">
                            {{ Form::label('Meta Title', 'Meta Title') }}
                            {{ Form::text('meta_h1', @$post->meta_h1, ['placeholder' => 'Meta Title', 'class' => 'form-control meta_h1']) }}

                        </div>
                           <div class="form-group">
                            {{ Form::label('Author name', 'Author Name') }}
                            {{ Form::text('author_name', @$post->author_name, ['placeholder' => 'Author Name', 'class' => 'form-control','required'=>'required']) }}

                        </div>
                        <div class="form-group">
                            {{ Form::label('Publish Date', 'Publish Date') }}
                            {{ Form::date('publish_date', @$post->publish_date, ['placeholder' => 'Publish Date', 'class' => 'form-control','required'=>'required']) }}

                        </div>

                        <div class="form-group">
                            {{ Form::label('position', 'Position') }}<span class="required">*</span>
                            {{ Form::number('position', @$post->position, ['placeholder' => 'Position', 'class' => 'form-control title']) }}

                        </div>
			
                    </div>

                    <div class="box-footer">
                        {{ Form::submit('Update Post', ['class' => 'btn btn-warning']) }}
                    </div>
                    {!! Form::close() !!}

                </div>
                <!-- /.box -->


            </div>


        </div>
    </section> 
</div>
<!-- /.content-wrapper -->
<script>
    function getmeta(){
var id =$('.my_select_box').val();
 var title =$('.title').val();

$.ajax({
  type: "GET",
 url: APP_URL+"/postmeta/"+id,
  dataType: "json",
  success: function(data){
$(".meta_h1").val(title);
if(data.catname!=''){
    $(".meta_tag").val(title+","+data.catname);
}else{
$(".meta_tag").val(title);
}
  }
});


}
</script>
@include('admin.layouts.footer')

@endsection




