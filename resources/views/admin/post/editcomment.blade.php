@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Comment
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Comment</h3>
                         <div class="pull-right">
                <a href="{!! url('admin/postcomment'); !!}">{{ Form::button('Back', ['class' => 'btn btn-primary']) }}</a>
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

                    {{ Form::model($postComment, ['method' => 'post','url' => ['admin/updatepostcomment', @$postComment->id] ,'files' => true]) }}
                    {{csrf_field()}}
                    <div class="box-body">

                   

                        <div class="form-group">
                            {{ Form::label('title', 'Title') }}
                            {{ Form::text('title', @$postComment->title, ['placeholder' => 'Title', 'class' => 'form-control' ,'disabled']) }}
                        </div>
                        
                        <div class="form-group">
                            {{ Form::label('Author', 'Author') }}
                         

                            {{ Form::text('author', @$postComment->authorname, ['placeholder' => 'Title', 'class' => 'form-control' ,'disabled']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('User Name', 'User Name') }}<span class="required">*</span>
                            {{ Form::text('name', @$postComment->name, ['placeholder' => 'Title', 'class' => 'form-control' ]) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('User Email', 'User Email') }}<span class="required">*</span>
                            {{ Form::email('email', @$postComment->email, ['placeholder' => 'Title', 'class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('User Website', 'User Website') }}
                            {{ Form::text('website', @$postComment->website, ['placeholder' => 'Title', 'class' => 'form-control' ]) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('Comment', 'Comment') }}<span class="required">*</span>
                            {{ Form::textarea('comment', @$postComment->comment, ['placeholder' => 'Comment', 'class' => 'form-control']) }}
                        </div>
                        
                        
                    </div>

                    <div class="box-footer">
                        {{ Form::submit('Update Comment', ['class' => 'btn btn-primary']) }}
                    </div>
                    {!! Form::close() !!}

                </div>
                <!-- /.box -->


            </div>


        </div>
    </section> 
</div>
<!-- /.content-wrapper -->

@include('admin.layouts.footer')

@endsection




