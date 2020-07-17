@extends('admin.layouts.app')

@section('title', 'Manage Setting')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Website Setting
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">

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
                    {{ Form::model($setting, ['method' => 'post','url' => ['/admin/edit-setting', @$setting->id] ,'files' => true]) }}
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            {{ Form::label('site_name', 'Site Name') }}<span class="required">*</span>
                            {{ Form::text('site_name', @$setting->site_name, ['placeholder' => 'Site Name', 'class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('site_url', 'Site URL') }}<span class="required">*</span>
                            {{ Form::text('site_url', @$setting->site_url, ['placeholder' => 'Site Url', 'class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            <div class="pull-left">
                                {{ Form::label('logo', 'Logo') }}
                                <input type="file" name="logo" value="{{@$setting->logo_log}}">
                            </div>
                            <div class="pull-left">
                                @if(@$setting->logo_log)
                                <img src="{{Url::to('/')}}/public/uploadimage/{{@$setting->logo_log}}" width="70" class="img-thumbnail">
                                @endif
                            </div>	
                        </div>	
                        <div class="clearfix"></div>
                        <div class="form-group">
                            {{ Form::label('admin_email', 'Admin Email') }}<span class="required">*</span>
                            {{ Form::text('admin_email', @$setting->admin_email, ['placeholder' => 'Admin Email', 'class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('robot_email', 'Robot Email') }}<span class="required">*</span>
                            {{ Form::text('robot_email', @$setting->robot_email, ['placeholder' => 'Robot Email', 'class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('meta_description', 'Meta Description') }}
                            {{ Form::text('meta_description', @$setting->meta_description, ['placeholder' => 'Meta Description', 'class' => 'form-control','maxlength' => 300]) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('meta_key', 'Meta Keywords') }}
                            {{ Form::text('meta_key', @$setting->meta_key, ['placeholder' => 'Please enter comma seprated key words', 'class' => 'form-control','maxlength' => 300]) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('universityType', 'Change Admin Panel Design') }}
                            {{ Form::select('panel_color', array('#f39c12'=>'Default','#FF7F50'=>'coral','#2E8B57'=>'seagreen','#008B8B'=>'darkcyan','#1E90FF'=>'dodgerblue'),@$setting->panel_color,['class' => 'form-control chosen-select'])}}

                        </div>
                        <div class="form-group">
                            {{ Form::label('universityType', 'Side Menu Color') }}
                            {{ Form::select('side_menu', array('#222d32'=>'Default','#FF7F50'=>'coral'),@$setting->side_menu,['class' => 'form-control chosen-select'])}}

                        </div>
                    </div>
                    <div class="box-footer">
                        {{ Form::submit('Save', ['class' => 'btn btn-warning']) }}
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




