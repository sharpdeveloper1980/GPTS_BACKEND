 <!-- navigation -->

<nav class="header navbar navbar-expand-lg fixed-top @if(Route::current()->getName() == 'career-discovery') white-background @endif">
        <button class="menu-control" id="headerSidebarToggle"> <span class="navbar-toggler-icon"></span></button>
        <div class="logo-conatiner">
            <img class="w-100 white-logo" src="{{ asset('public/web/images/common/logo.png') }}">
            <img class="w-100 black-logo" src="{{ asset('public/web/images/common/logo-black.png') }}">
        </div>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <div class="login-nav  w-100 align-items-center d-flex">
                <div class="ml-auto text-white small-text">New User? Register Now</div>
                <button class="transparent-button login-button" data-toggle="modal" data-target="#exampleModal">LOGIN</button>
            </div>
            <div class="logged-in-nav d-flex w-100 align-items-center justify-content-end" style="display: none !important;">
                <div class="header-search" id="searchIcon">
                    <img src="{{ asset('public/web/images/common/search.png') }}">
                </div>
                <button class="primary-button login-button">DASHBOARD</button>
                <a href="career-discovery-test.html" class="transparent-button login-button position-relative"><span class="badge badge-pill badge-danger">1</span>Compare</a>
                <button class="transparent-button login-button position-relative"><span class="badge badge-pill badge-danger">2</span>Shortlisted</button>
                <div class="dropdown">
                    <button type="button" class="transparent-button border-0 dropdown-toggle ml-0 p-0" data-toggle="dropdown">
                        Dropdown button
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Link 1</a>
                        <a class="dropdown-item" href="#">Link 2</a>
                        <a class="dropdown-item" href="#">Link 3</a>
                    </div>
                </div>
            </div>
        </div>
</nav>