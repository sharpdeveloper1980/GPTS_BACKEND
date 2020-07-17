@extends('web.layouts.app')
@section('content')
@include('web.layouts.header')
@include('web.layouts.header-search')
    <!-- header image -->
    <div class="container-fluid">
        <div class="row">
            <div class="poster-image"> <img class="poster-image" src="{{ asset('public/web/images/comparison/comparison-poster.png')}}"> </div>
        </div>
    </div>
    <div class="container">
        <!-- heading -->
        <div class="row">
            <div class="col-12">
                <h3 class="headingThree text-center">FAQs</h3> </div>
        </div>
        <!-- paragraph -->
        <div class="row">
            <div class="col-12">
                <p class="paraOne">Proident, ipsum fugiat officia. Aliqua ut ad incididunt. Voluptate Lorem Duis veniam, elit. In nulla dolore nostrud est laborum. Cupidatat laboris sint ex. Ut qui irure aute. Non adipiscing voluptate fugiat velit. Ex et ipsum pariatur. Ea occaecat occaecat consectetur culpa ipsum. Eiusmod fugiat magna ad sunt.</p>
            </div>
        </div>
        <!-- choose category -->
        <div class="row">
            <div class="col-12">
                <h4 class="text-center chooseTxt">choose category get quick access of what you are looking for</h4> </div>
        </div>
    </div>
    <!-- faq tabs -->
    <div class="container">
        <!-- navigation -->
        <div class="row">
            <div class="col">
                <ul class="nav nav-tabs nav-tabsFaq centerEverything">
                    <li class="nav-item"> <a class="nav-link faqactive text-center active" data-toggle="tab" href="#q0">Frequently Asked Question 00</a> </li>
                    <li class="nav-item"> <a class="nav-link faqactive text-center" data-toggle="tab" href="#q1">Frequently Asked Question 01</a> </li>
                    <li class="nav-item"> <a class="nav-link faqactive text-center" data-toggle="tab" href="#q2">Frequently Asked Question 02</a> </li>
                    <li class="nav-item"> <a class="nav-link faqactive text-center" data-toggle="tab" href="#q3">Frequently Asked Question 03</a> </li>
                    <li class="nav-item"> <a class="nav-link faqactive text-center" data-toggle="tab" href="#q4">Frequently Asked Question 04</a> </li>
                    <li class="nav-item"> <a class="nav-link faqactive text-center" data-toggle="tab" href="#q5">Frequently Asked Question 05</a> </li>
                    <li class="nav-item"> <a class="nav-link faqactive text-center" data-toggle="tab" href="#q6">Frequently Asked Question 06</a> </li>
                    <li class="nav-item"> <a class="nav-link faqactive text-center" data-toggle="tab" href="#q7">Frequently Asked Question 07</a> </li>
                </ul>
            </div>
        </div>
        <!-- tab content -->
        <div class="row">
            <div class="col-12">
                <h5 class="recentlyHeading">Recently Answered Questions</h5> </div>
            <div class="col-12">
                <div class="tab-content tab-contentFaq">
                    <div class="tab-pane active" id="q0">
                        <!-- question -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="text-uppercase faqNumber">faq. 1</p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqQuestion">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu?</p>
                            </div>
                        </div>
                        <!-- answer -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="faqNumber"> </p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqAnswer">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu aute dolor velit et dolor sit dolore pariatur exercitation adipiscing deserunt ea mollit Lorem aliquip in ex ad et dolor eiusmod adipiscing fugiat ullamco non. Non velit velit in id dolore elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="q1">
                        <!-- question -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="text-uppercase faqNumber">faq. 2</p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqQuestion">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu?</p>
                            </div>
                        </div>
                        <!-- answer -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="faqNumber"> </p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqAnswer">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu aute dolor velit et dolor sit dolore pariatur exercitation adipiscing deserunt ea mollit Lorem aliquip in ex ad et dolor eiusmod adipiscing fugiat ullamco non. Non velit velit in id dolore elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="q2">
                        <!-- question -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="text-uppercase faqNumber">faq. 3</p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqQuestion">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu?</p>
                            </div>
                        </div>
                        <!-- answer -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="faqNumber"> </p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqAnswer">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu aute dolor velit et dolor sit dolore pariatur exercitation adipiscing deserunt ea mollit Lorem aliquip in ex ad et dolor eiusmod adipiscing fugiat ullamco non. Non velit velit in id dolore elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="q3">
                        <!-- question -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="text-uppercase faqNumber">faq. 4</p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqQuestion">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu?</p>
                            </div>
                        </div>
                        <!-- answer -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="faqNumber"> </p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqAnswer">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu aute dolor velit et dolor sit dolore pariatur exercitation adipiscing deserunt ea mollit Lorem aliquip in ex ad et dolor eiusmod adipiscing fugiat ullamco non. Non velit velit in id dolore elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="q4">
                        <!-- question -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="text-uppercase faqNumber">faq. 5</p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqQuestion">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu?</p>
                            </div>
                        </div>
                        <!-- answer -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="faqNumber"> </p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqAnswer">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu aute dolor velit et dolor sit dolore pariatur exercitation adipiscing deserunt ea mollit Lorem aliquip in ex ad et dolor eiusmod adipiscing fugiat ullamco non. Non velit velit in id dolore elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="q5">
                        <!-- question -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="text-uppercase faqNumber">faq. 6</p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqQuestion">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu?</p>
                            </div>
                        </div>
                        <!-- answer -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="faqNumber"> </p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqAnswer">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu aute dolor velit et dolor sit dolore pariatur exercitation adipiscing deserunt ea mollit Lorem aliquip in ex ad et dolor eiusmod adipiscing fugiat ullamco non. Non velit velit in id dolore elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="q6">
                        <!-- question -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="text-uppercase faqNumber">faq. 7</p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqQuestion">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu?</p>
                            </div>
                        </div>
                        <!-- answer -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="faqNumber"> </p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqAnswer">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu aute dolor velit et dolor sit dolore pariatur exercitation adipiscing deserunt ea mollit Lorem aliquip in ex ad et dolor eiusmod adipiscing fugiat ullamco non. Non velit velit in id dolore elit.</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="q7">
                        <!-- question -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="text-uppercase faqNumber">faq. 1</p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqQuestion">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu?</p>
                            </div>
                        </div>
                        <!-- answer -->
                        <div class="row">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12">
                                <p class="faqNumber"> </p>
                            </div>
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-12">
                                <p class="faqAnswer">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu aute dolor velit et dolor sit dolore pariatur exercitation adipiscing deserunt ea mollit Lorem aliquip in ex ad et dolor eiusmod adipiscing fugiat ullamco non. Non velit velit in id dolore elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- faq tabs ens -->
   @include('web.layouts.common')
   
 </div>

@include('web.layouts.footer')
@endsection