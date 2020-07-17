@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Categories
        </h1>
    </section>
    <section class="content">

        <div class="row">
            <div class="pull-right">
                
               
            </div>
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Category</h3>
                         <div class="pull-right">
                <a href="{!! url('admin/category'); !!}">{{ Form::button('Back', ['class' => 'btn btn-warning']) }}</a>
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

                    {{ Form::model($category, ['method' => 'post','url' => ['admin/editcategory', @$category->id] ,'files' => true]) }}
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            {{ Form::label('name', 'Name') }}<span class="required">*</span>
                            {{ Form::text('name', @$category->name, ['placeholder' => 'Name', 'class' => 'form-control title','onchange' => 'getmeta()']) }}
                          
                        </div>

                        <div class="form-group">
                            {{ Form::label('slug', 'Slug') }}
                            {{ Form::text('slug', @$category->slug, ['placeholder' => 'Slug', 'class' => 'form-control slug']) }}
                            
                        </div>
                        <div class="form-group">
                            {{ Form::label('Image', 'Image') }}
                            @if(@$category->img!='')
                            <div class="img-wrap">
                                 <a href="{!! url('/deleteImg'); !!}/{{@$category->img}}/{{@$category->id}}"  onclick = "if (!confirm('Are you sure, want to delete this image?')) {
                                            return false;
                                        }"  title="Delete">
                                <span class="close">&times;</span>
                                 </a>
                          <img src="{{URL::asset("/postimage/".@$category->img)}}" width="250" height="250" alt="Category Image">
                            </div>                                                       
                            @endif
                            <input type="file" name="img" value="{{@$category->img}}" class="form-control">
                            <!--{{ Form::file('img', ['placeholder' => 'Img', 'class' => 'form-control']) }}-->
                        </div>
                        <div class="form-group">
                            {{ Form::label('description', 'Description') }}
                            {{ Form::textarea('description', @$category->description, ['placeholder' => 'Description', 'class' => 'form-control']) }}

                        </div>
                        <div class="form-group">
				{{ Form::label('Meta Description', 'Meta Description') }}
				{{ Form::textarea('meta_description', @$category->meta_description, ['placeholder' => 'Meta Description', 'class' => 'form-control']) }}
				
				</div>
                             <div class="form-group">
				{{ Form::label('Meta Tags', 'Meta Tags') }}
				{{ Form::textarea('meta_tag', @$category->meta_tag, ['placeholder' => 'Meta Tags', 'class' => 'form-control meta_tag']) }}
				
				</div>
                             <div class="form-group">
				{{ Form::label('Meta Title', 'Meta Title') }}
				{{ Form::textarea('meta_h1', @$category->meta_h1, ['placeholder' => 'Meta Title', 'class' => 'form-control meta_h1']) }}
				
				</div>
                    </div>

                    <div class="box-footer">
                        {{ Form::submit('Update Category', ['class' => 'btn btn-warning']) }}
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
 var title =$('.title').val();
$(".meta_tag").val(title);
$(".meta_h1").val(title);



}
</script>
@include('admin.layouts.footer')

@endsection




