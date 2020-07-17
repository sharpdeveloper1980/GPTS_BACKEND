@extends('admin.layouts.app')

@section('title', 'Not Allow Page')

@section('content')

@include('admin.layouts.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Welcome Admin
        <!--<small>Blank example to the fixed layout</small>-->
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
      <strong>You are not allow to access this page</strong>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
@include('admin.layouts.footer')

@endsection




