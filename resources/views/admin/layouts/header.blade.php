<body class="hold-transition skin-yellow fixed sidebar-mini">
    <div class="wrapper">
        <!-- Site wrapper -->
        <header class="main-header">
            <!-- Logo -->
            <a href="{{URL::to('/')}}/admin/dashboard" class="logo" style="background-color: {{@$setting->panel_color}}">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>{{@$setting->site_name}}</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>{{Config::get('constants.ADMIN_TITLE')}}</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" style="background-color: {{@$setting->panel_color}}">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </a>

                                                     <div class="navbar-custom-menu">
                                    <ul class="nav navbar-nav">
                                 <li class="dropdown user user-menu">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{Url::to('/')}}/public/uploadimage/{{@$setting->logo_log}}" class="img-circle" width="16" height="16">
                                                <span class="hidden-xs">{{Config::get('constants.ADMIN_TITLE')}}</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <!-- User image -->
                                                <li class="user-header">
                                                    <img src="{{Url::to('/')}}/public/uploadimage/{{@$setting->logo_log}}" class="img-circle" width="45" height="45">	
                                                    <p>
                                                        {{Config::get('constants.ADMIN_TITLE')}}
                                                    </p>
                                                </li>
                                                <!-- Menu Footer-->
                                                <li class="user-footer">
                                                    <!--<div class="pull-left">
                                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                                    </div>-->
                                                    <div class="pull-right">
                                                        <a href="{{ URL::to('logout') }}" class="btn btn-warning btn-flat">Sign out</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </div>
                                </nav>
                                </header>

                                <aside class="main-sidebar" style="background-color: {{@$setting->side_menu}}">
                                    <!-- sidebar: style can be found in sidebar.less -->
                                    <section class="sidebar">
                                        <!-- Sidebar user panel -->
                                        <!-- <div class="user-panel">
                                             <div class="pull-left image">
                                                                         <img src="{{Url::to('/')}}/public/image/logo.png" class="img-circle" width="100" height="100">
                                             </div>
                                             <div class="pull-left info">
                                                 <p>{{Config::get('constants.ADMIN_TITLE')}}</p>
                                             </div>
                                         </div>-->

                                        <!-- sidebar menu: : style can be found in sidebar.less -->
                                        <ul class="sidebar-menu" data-widget="tree">
                                            <!--<li class="header">MAIN NAVIGATION</li>-->
                                            <li class="">
                                                <a href="{{URL::to('/')}}/admin/dashboard">
                                                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="{{ url('/home-page-videos') }}">
                                                    <i class="fa fa-file-video-o"></i> <span>Home Page Videos</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="{{ url('/admin/university-listing') }}">
                                                    <i class="fa fa-file-video-o"></i> <span>University Listing</span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="{{ url('/admin/courses-listing') }}">
                                                    <i class="fa fa-file-video-o"></i> <span>Sub-Stream Listing</span>
                                                </a>
                                            </li>


                                            @foreach($menu as $keymenu)
                                            <!--<li class="treeview menu-open">-->
                                            <li class="@if(count($keymenu['submenu'])>0) treeview @endif}}">
                                                @if(count($keymenu['submenu'])>0)
                                                <a href="#">
                                                    <i class="fa {{$keymenu['icon']}}"></i>
                                                    <span>{{$keymenu['menu']}}</span>
                                                    <span class="pull-right-container">
                                                        <i class="fa fa-angle-left pull-right"></i>
                                                    </span>
                                                </a>

                                                <!--<ul class="treeview-menu" style="display:block;">-->
                                                <ul class="treeview-menu">
                                                    @foreach($keymenu['submenu'] as $submenukey)
                                                    <li><a href="{!! url('/admin')!!}/{{$submenukey->link}}"><i class="fa {{$submenukey->icon}}"></i>{{$submenukey->menu}}</a></li>
                                                    @endforeach
                                                </ul>

                                                @else
                                                <a href="{!! url('/admin')!!}/{{$keymenu['link']}}">

                                                    <i class="fa {{$keymenu['icon']}}"></i>
                                                    <span>{{$keymenu['menu']}}</span>
                                                </a>

                                                @endif


                                            </li>
                                            @endforeach

                                        </ul>
                                    </section>
                                    <!-- /.sidebar -->
                                </aside>