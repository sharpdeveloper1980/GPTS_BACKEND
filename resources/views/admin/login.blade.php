@extends('admin.layouts.app')

@section('title', 'Admin Login')

<body class="hold-transition login-page">

@section('content')

	<div class="login-container">
		<div class="login-box">
			<div class="login-box-body">
				<div class="login-logo">
					<img src="{{Url::to('/')}}/public/image/logo.png">
					{{--Config::get('constants.ADMIN_TITLE')--}}
				</div>
				<!-- /.login-logo -->
				<div class="row">
					<h4 class="text-center">Admin Login</h4>
					<hr>
				</div>
				@if(session()->has('error')) <p class="text-center" style="color: #F00;font-size: 18px;"> {{session()->get('error')}} </p> @endif
				@if(session()->has('success') && session()->get('success')!='') <div class="row"><div class="alert alert-success"> {{session()->get('success')}} </div></div> @endif
				<form class="form-horizontal" role="form" method="POST" action="administrator">
					{!! csrf_field() !!}
					<div class="form-group has-feedback">
						<input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="Email" required="required">
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					@if ($errors->has('email'))
					<span class="help-block error">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
					@endif
					<div class="form-group has-feedback">
						<input type="password" class="form-control" placeholder="Password" name="password" required="required">
						<span class="fa fa-lock form-control-feedback"></span>
					</div>

					@if ($errors->has('password'))
					<span class="help-block error">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
					@endif
					<div class="row login-button ">
						<div class="col-xs-8 pull-lg">
						<a href="{{URL::to('/admin/forgot-password')}}">I forgot my password ?</a><br>
						</div>
						<!-- /.col -->
						<div class="col-xs-4 pull-right pull-rg">
						<button type="submit" class="btn btn-warning btn-block btn-flat">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
			</div>
			<!-- /.login-box-body -->
		</div>
	</div>

<!-- /.login-box -->
@endsection