@extends('admin.layouts.app')

@section('title', 'Admin Login')

<body class="hold-transition login-page">
@section('content')
<div class="login-container">
  <div class="login-box">
  <div class="login-box-body">
	<div class="login-logo">
		<img src="{{URL::asset('/public/image/logo-one.png')}}" width="190" height="170">
		{{--Config::get('constants.ADMIN_TITLE')--}}
	  </div>
	  <!-- /.login-logo -->
	<div class="row">
		<hr>
		@if(session()->has('success') && session()->get('success')!='') <div class="row"><div class="alert alert-success"> {{session()->get('success')}} </div></div> @endif
		
		<h4>Forgot Password</h4>
		<h5>Enter the email address associated with your account to reset your password.</h5>
	</div>
    <form class="form-horizontal"  role="form" method="POST" action="sendToken">
	{!! csrf_field() !!}
      <div class="form-group has-feedback">
        <input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="Email" required="required">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
	   @if ($errors->has('email') || session()->has('forgoterror'))
                                    <span class="help-block error">
                                        <strong>{{ $errors->first('email')}}{{session()->get('forgoterror')}}</strong>
                                    </span>
       @endif  
		
		
	 <div class="row login-button ">
       <div class="col-xs-4 pull-lg">
              <a href="{{URL::to('/administrator')}}" class="btn btn-warning btn-block btn-flat">Login</a>
        </div>
        <!-- /.col -->
        <div class="col-xs-4 pull-right pull-rg">
          <button type="submit" class="btn btn-warning btn-block btn-flat">Submit</button>
        </div>
        <!-- /.col -->
      </div>
	  
    </form>



  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</div>
@endsection