@extends('admin.layouts.app')

@section('title', 'Admin Login')

<body class="hold-transition login-page">

@section('content')

<div class="login-container">
  <div class="login-box">

  <div class="login-box-body">

	  <div class="login-logo">
	<img src="{{URL::asset('/public/image/logo-one.png')}}" >
    {{--Config::get('constants.ADMIN_TITLE')--}}
  </div>
  <!-- /.login-logo -->
	
	@if(session()->get('reseterror') == '')
	<h3>Reset Password</h3>
    <form class="form-horizontal"  role="form" method="POST" action="{{URL::to('admin/reset-password')}}/{{$token}}">
	{!! csrf_field() !!}
      <div class="form-group has-feedback">
        <input type="password" value="{{ old('password') }}" name="password" class="form-control" placeholder="New Password" required>
        <span class="fa fa-lock form-control-feedback"></span>
      </div>
	   
	   
		<div class="form-group has-feedback">	
		<input type="password" value="{{ old('password_confirmation') }}" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        <span class="fa fa-lock form-control-feedback"></span>
      </div>
	   @if ($errors->has('password'))
                <span class="help-block error">
                     <strong>{{ $errors->first('password')}}</strong>
                </span>
       @endif  
		
	 <div class="row login-button ">
       <div class="col-xs-4 pull-lg">
              <a href="{{URL::to('/administrator')}}" class="btn btn-warning btn-block btn-flat">login</a><br>
        </div>
        <!-- /.col -->
        <div class="col-xs-5 pull-right pull-rg">
          <button type="submit" class="btn btn-warning btn-block btn-flat">Reset Password</button>
        </div>
        <!-- /.col -->
      </div>
	  
    </form>

	@else
	<div class="clearfix"></div>
	<div class="alert alert-danger alert-dismissible fade in col-xs-12">
		{{session()->get('reseterror')}}
	</div>
	<div class="clearfix"></div>
  @endif

  </div>
  <!-- /.login-box-body -->
</div>

</div>

<!-- /.login-box -->
@endsection