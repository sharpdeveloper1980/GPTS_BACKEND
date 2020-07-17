@extends('web.layouts.app')
@section('content')
@include('web.layouts.header')
@include('web.layouts.header-search')

<div class="container headingTopMargin">
        <div class="row">
            <!-- filter -->
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                <div class="col-12 border removePadding">
                    <h3 class="filterHeading">Filters</h3>
                    <!-- accordion fitler starts -->
                    <div id="accordion">
                        <div class="card cardCustomFilter">
                            <div class="card-header cardHeaderCustom"> 
							<a class="card-link" data-toggle="collapse" href="#collapseOne">
							KPI <i class="fas fa-angle-right">		 </i>
							</a> </div>
                            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                <div class="card-body">
                                    <ul class="unstyled centered">
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1">
                                            <label for="styled-checkbox-1">Learning Experience</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" value="value2" checked>
                                            <label for="styled-checkbox-2">Happiness Factor</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Parents Satisfaction</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Life on Campus</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Infrastructre</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Extra Curricular Activities</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card cardCustomFilter">
                            <div class="card-header cardHeaderCustom"> <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
        Degree <i class="fas fa-angle-right"></i>
      </a> </div>
                            <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <ul class="unstyled centered">
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1">
                                            <label for="styled-checkbox-1"> UG</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" value="value2" checked>
                                            <label for="styled-checkbox-2">PG </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card cardCustomFilter">
                            <div class="card-header cardHeaderCustom"> <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
          Course <i class="fas fa-angle-right"></i>
        </a> </div>
                            <div id="collapseThree" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <ul class="unstyled centered">
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1">
                                            <label for="styled-checkbox-1">Learning Experience</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" value="value2" checked>
                                            <label for="styled-checkbox-2">Happiness Factor</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Parents Satisfaction</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Life on Campus</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Infrastructre</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Extra Curricular Activities</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card cardCustomFilter">
                            <div class="card-header cardHeaderCustom"> <a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">
          Mode of Study <i class="fas fa-angle-right"></i>
        </a> </div>
                            <div id="collapseFour" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <ul class="unstyled centered">
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1">
                                            <label for="styled-checkbox-1">Learning Experience</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" value="value2" checked>
                                            <label for="styled-checkbox-2">Happiness Factor</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Parents Satisfaction</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Life on Campus</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Infrastructre</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Extra Curricular Activities</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card cardCustomFilter">
                            <div class="card-header cardHeaderCustom"> <a class="collapsed card-link" data-toggle="collapse" href="#collapseFive">
          Intake Year <i class="fas fa-angle-right"></i>
        </a> </div>
                            <div id="collapseFive" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <select class="form-control filterformCOntrol">
                                        <option>2018 - 19</option>
                                        <option>2018 - 19</option>
                                        <option>2018 - 19</option>
                                        <option>2018 - 19</option>
                                        <option>2018 - 19</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card cardCustomFilter">
                            <div class="card-header cardHeaderCustom"> <a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">
          University <i class="fas fa-angle-right"></i>
        </a> </div>
                            <div id="collapseFour" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <ul class="unstyled centered">
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1">
                                            <label for="styled-checkbox-1">Learning Experience</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" value="value2" checked>
                                            <label for="styled-checkbox-2">Happiness Factor</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Parents Satisfaction</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Life on Campus</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Infrastructre</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Extra Curricular Activities</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card cardCustomFilter">
                            <div class="card-header cardHeaderCustom"> <a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">
          Ownership <i class="fas fa-angle-right"></i>
        </a> </div>
                            <div id="collapseFour" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <ul class="unstyled centered">
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1">
                                            <label for="styled-checkbox-1">Learning Experience</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" value="value2" checked>
                                            <label for="styled-checkbox-2">Happiness Factor</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Parents Satisfaction</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Life on Campus</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Infrastructre</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Extra Curricular Activities</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card cardCustomFilter">
                            <div class="card-header cardHeaderCustom"> <a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">
          Types of University <i class="fas fa-angle-right"></i>
        </a> </div>
                            <div id="collapseFour" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <ul class="unstyled centered">
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1">
                                            <label for="styled-checkbox-1">Learning Experience</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" value="value2" checked>
                                            <label for="styled-checkbox-2">Happiness Factor</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Parents Satisfaction</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Life on Campus</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Infrastructre</label>
                                        </li>
                                        <li>
                                            <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                            <label for="styled-checkbox-4">Extra Curricular Activities</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card cardCustomFilter">
                            <div class="card-header cardHeaderCustom"> <a class="collapsed card-link" data-toggle="collapse" href="#collapseFive">
          Location <i class="fas fa-angle-right"></i>
        </a> </div>
                            <div id="collapseFive" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <div>
                                        <label class="filterLabel">Select Country</label>
                                        <select class="form-control filterformCOntrol">
                                            <option>India</option>
                                            <option>India</option>
                                            <option>India</option>
                                            <option>India</option>
                                            <option>India</option>
                                            <option>India</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="filterLabel">Select State</label>
                                        <select class="form-control filterformCOntrol">
                                            <option>Noida</option>
                                            <option>India</option>
                                            <option>India</option>
                                            <option>India</option>
                                            <option>India</option>
                                            <option>India</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card cardCustomFilter">
                            <div class="card-header cardHeaderCustom"> <a class="collapsed card-link" data-toggle="collapse" href="#collapseSix">
          Campus Sitiing <i class="fas fa-angle-right"></i>
        </a> </div>
                            <div id="collapseSix" class="collapse" data-parent="#accordion">
                                <div class="card-body d-flex">
                                    <div class="col-6 text-xs-center">
                                        <label class="image-checkbox" title="Germany"> <img src="{{ asset('public/web/images/common/semi-urban.png') }}" class="img-fluid center-block" alt="images" />
                                            <input type="checkbox" name="team[]" value="germany" checked /> </label>
                                    </div>
                                    <div class="col-6 text-xs-center">
                                        <label class="image-checkbox" title="Italy"> <img src="{{ asset('public/web/images/common/urban.png')}}" class="img-fluid center-block" alt="images" />
                                            <input type="checkbox" name="team[]" value="italy" /> </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card cardCustomFilter">
                            <div class="card-header cardHeaderCustom"> <a class="collapsed card-link" data-toggle="collapse" href="#collapseSeven">
          Fee <i class="fas fa-angle-right"></i>
        </a> </div>
                            <div id="collapseSeven" class="collapse" data-parent="#accordion">
                                <div class="card-body d-flex">
                                    <div class="range-slider"><span>
    INR<input type="number" value="25000" min="0" max="120000"/>	to
    INR<input type="number" value="50000" min="0" max="120000"/></span>
                                        <input value="25000" min="0" max="120000" step="500" type="range" />
                                        <input value="50000" min="0" max="120000" step="500" type="range" />
                                        <svg width="100%" height="24">
                                            <!--<line x1="4" y1="0" x2="300" y2="0" stroke="#444" stroke-width="12" stroke-dasharray="1 28"></line>-->
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- result -->
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-12">
                <!-- set one -->
                <div class="col-12 removePadding whiteSearchBox">
                    <div class="d-xl-flex d-lg-flex d-md-flex">
                        <!-- logo -->
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 centerEverything">
                            <div class="logoBox"> <img src="{{ asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block logoWidthSearch" alt="image"> </div>
                        </div>
                        <!-- text details -->
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12 removePadding">
                            <hr class="rightSearchResult">
                            <!-- course name -->
                            <p class="courseName">Bachelor in Cinematic Arts</p>
                            <!-- course school -->
                            <p class="courseSchool">USC School of Cinematic Arts</p>
                            <!-- location -->
                            <p class="courseLocation">Southern California, USA</p>
                            <!-- duration -->
                            <p><span class="yearTime">4 years</span> | <span class="durationTime">Fulltime</span> </p>
                            <!-- fees + exams -->
                            <div class="col-12 removePadding d-xl-flex d-lg-flex d-md-flex">
                                <!-- fee -->
                                <div class="col-6 removePadding"><span class="feeTitle">Approximate Fee</span><span class="feesRupees">INR 6,50,000 pa</span></div>
                                <!-- padding -->
                                <div class="col-6 removePadding text-center"><span class="feeTitle">Entrance Exam Required</span><span class="feesRupees text-uppercase">ielts, ceed, uceed,aieed,aift,wat,fddi, aist</span></div>
                            </div>
                        </div>
                        <!-- ratings -->
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <h5 class="text-center greatHeading">Great Place To Study Rating</h5>
                            <!-- chart -->
                            <div class="second circle"> <strong></strong> <span>4.39</span> </div>
                            <!-- ratings -->
                            <div class="centerEverything">
                                <meter class="c-starRating" max="5" min="0" value="4.7"></meter>
                            </div>
                            <!-- certified -->
                            <div>
                                <p class="text-uppercase certifiedText">Certified</p>
                            </div>
                        </div>
                    </div>
                    <!-- icons set -->
                    <div class="col-12 removePadding border-top d-xl-flex d-lg-flex d-md-flex iconPaddingTop">
                        <div class="col"><img src="{{ asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{ asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{ asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{ asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{ asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{ asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{ asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                    </div>
                    <!-- call to action -->
                    <div class="col-12 removePadding border-top d-xl-flex d-lg-flex d-md-flex">
                        <!-- left -->
                        <div class="col-6"> <a href="#" class="shortlist">Shortlist</a> <a href="#" class="compare">Compare</a> </div>
                        <!-- right -->
                        <div class="col-6"> <a href="#" class="compareBtn">Add to Common App</a> </div>
                    </div>
                </div>
                <!-- set one ends -->
                <div class="col-12 removePadding whiteSearchBox">
                    <div class="d-xl-flex d-lg-flex d-md-flex">
                        <!-- logo -->
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 centerEverything">
                            <div class="logoBox"> <img src=" {{asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block logoWidthSearch" alt="image"> </div>
                        </div>
                        <!-- text details -->
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12 removePadding">
                            <hr class="rightSearchResult">
                            <!-- course name -->
                            <p class="courseName">Bachelor in Cinematic Arts</p>
                            <!-- course school -->
                            <p class="courseSchool">USC School of Cinematic Arts</p>
                            <!-- location -->
                            <p class="courseLocation">Southern California, USA</p>
                            <!-- duration -->
                            <p><span class="yearTime">4 years</span> | <span class="durationTime">Fulltime</span> </p>
                            <!-- fees + exams -->
                            <div class="col-12 removePadding d-xl-flex d-lg-flex d-md-flex">
                                <!-- fee -->
                                <div class="col-6 removePadding"><span class="feeTitle">Approximate Fee</span><span class="feesRupees">INR 6,50,000 pa</span></div>
                                <!-- padding -->
                                <div class="col-6 removePadding text-center"><span class="feeTitle">Entrance Exam Required</span><span class="feesRupees text-uppercase">ielts, ceed, uceed,aieed,aift,wat,fddi, aist</span></div>
                            </div>
                        </div>
                        <!-- ratings -->
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <h5 class="text-center greatHeading">Great Place To Study Rating</h5>
                            <!-- chart -->
                            <div class="second circle"> <strong></strong> <span>4.39</span> </div>
                            <!-- ratings -->
                            <div class="centerEverything">
                                <meter class="c-starRating" max="5" min="0" value="4.7"></meter>
                            </div>
                            <!-- certified -->
                            <div>
                                <p class="text-uppercase certifiedText">Certified</p>
                            </div>
                        </div>
                    </div>
                    <!-- icons set -->
                    <div class="col-12 removePadding border-top d-xl-flex d-lg-flex d-md-flex iconPaddingTop">
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                    </div>
                    <!-- call to action -->
                    <div class="col-12 removePadding border-top d-xl-flex d-lg-flex d-md-flex">
                        <!-- left -->
                        <div class="col-6"> <a href="#" class="shortlist">Shortlist</a> <a href="#" class="compare">Compare</a> </div>
                        <!-- right -->
                        <div class="col-6"> <a href="#" class="compareBtn">Add to Common App</a> </div>
                    </div>
                </div>
                <div class="col-12 removePadding whiteSearchBox">
                    <div class="d-xl-flex d-lg-flex d-md-flex">
                        <!-- logo -->
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 centerEverything">
                            <div class="logoBox"> <img src="{{asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block logoWidthSearch" alt="image"> </div>
                        </div>
                        <!-- text details -->
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12 removePadding">
                            <hr class="rightSearchResult">
                            <!-- course name -->
                            <p class="courseName">Bachelor in Cinematic Arts</p>
                            <!-- course school -->
                            <p class="courseSchool">USC School of Cinematic Arts</p>
                            <!-- location -->
                            <p class="courseLocation">Southern California, USA</p>
                            <!-- duration -->
                            <p><span class="yearTime">4 years</span> | <span class="durationTime">Fulltime</span> </p>
                            <!-- fees + exams -->
                            <div class="col-12 removePadding d-xl-flex d-lg-flex d-md-flex">
                                <!-- fee -->
                                <div class="col-6 removePadding"><span class="feeTitle">Approximate Fee</span><span class="feesRupees">INR 6,50,000 pa</span></div>
                                <!-- padding -->
                                <div class="col-6 removePadding text-center"><span class="feeTitle">Entrance Exam Required</span><span class="feesRupees text-uppercase">ielts, ceed, uceed,aieed,aift,wat,fddi, aist</span></div>
                            </div>
                        </div>
                        <!-- ratings -->
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <h5 class="text-center greatHeading">Great Place To Study Rating</h5>
                            <!-- chart -->
                            <div class="second circle"> <strong></strong> <span>4.39</span> </div>
                            <!-- ratings -->
                            <div class="centerEverything">
                                <meter class="c-starRating" max="5" min="0" value="4.7"></meter>
                            </div>
                            <!-- certified -->
                            <div>
                                <p class="text-uppercase certifiedText">Certified</p>
                            </div>
                        </div>
                    </div>
                    <!-- icons set -->
                    <div class="col-12 removePadding border-top d-xl-flex d-lg-flex d-md-flex iconPaddingTop">
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                    </div>
                    <!-- call to action -->
                    <div class="col-12 removePadding border-top d-xl-flex d-lg-flex d-md-flex">
                        <!-- left -->
                        <div class="col-6"> <a href="#" class="shortlist">Shortlist</a> <a href="#" class="compare">Compare</a> </div>
                        <!-- right -->
                        <div class="col-6"> <a href="#" class="compareBtn">Add to Common App</a> </div>
                    </div>
                </div>
                <div class="col-12 removePadding whiteSearchBox">
                    <div class="d-xl-flex d-lg-flex d-md-flex">
                        <!-- logo -->
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 centerEverything">
                            <div class="logoBox"> <img src="{{asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block logoWidthSearch" alt="image"> </div>
                        </div>
                        <!-- text details -->
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12 removePadding">
                            <hr class="rightSearchResult">
                            <!-- course name -->
                            <p class="courseName">Bachelor in Cinematic Arts</p>
                            <!-- course school -->
                            <p class="courseSchool">USC School of Cinematic Arts</p>
                            <!-- location -->
                            <p class="courseLocation">Southern California, USA</p>
                            <!-- duration -->
                            <p><span class="yearTime">4 years</span> | <span class="durationTime">Fulltime</span> </p>
                            <!-- fees + exams -->
                            <div class="col-12 removePadding d-xl-flex d-lg-flex d-md-flex">
                                <!-- fee -->
                                <div class="col-6 removePadding"><span class="feeTitle">Approximate Fee</span><span class="feesRupees">INR 6,50,000 pa</span></div>
                                <!-- padding -->
                                <div class="col-6 removePadding text-center"><span class="feeTitle">Entrance Exam Required</span><span class="feesRupees text-uppercase">ielts, ceed, uceed,aieed,aift,wat,fddi, aist</span></div>
                            </div>
                        </div>
                        <!-- ratings -->
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                            <h5 class="text-center greatHeading">Great Place To Study Rating</h5>
                            <!-- chart -->
                            <div class="second circle"> <strong></strong> <span>4.39</span> </div>
                            <!-- ratings -->
                            <div class="centerEverything">
                                <meter class="c-starRating" max="5" min="0" value="4.7"></meter>
                            </div>
                            <!-- certified -->
                            <div>
                                <p class="text-uppercase certifiedText">Certified</p>
                            </div>
                        </div>
                    </div>
                    <!-- icons set -->
                    <div class="col-12 removePadding border-top d-xl-flex d-lg-flex d-md-flex iconPaddingTop">
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                        <div class="col"><img src="{{asset('public/web/images/common/cycle.png')}}" class="img-fluid center-block" alt="image"></div>
                    </div>
                    <!-- call to action -->
                    <div class="col-12 removePadding border-top d-xl-flex d-lg-flex d-md-flex">
                        <!-- left -->
                        <div class="col-6"> <a href="#" class="shortlist">Shortlist</a> <a href="#" class="compare">Compare</a> </div>
                        <!-- right -->
                        <div class="col-6"> <a href="#" class="compareBtn">Add to Common App</a> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- pagination -->
    <div class="container">
        <div class="row">
            <div class="col-12 centerEverything">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- featured design college -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3 class="headingThreeOne">Featured Design Colleges & Institutes</h3> </div>
            <div class="col-12">
                <div class="gptsCertified">
                    <div>
                        <div class="boxCertified"> <img src="{{asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                </div>
            </div>
           <!-- button -->
<div class="col-12 centerEverything">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div>
    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-4 col-12">
        <button type="button" class="btn btn-success btn-customSuccess removeBorderRadius text-uppercase">View all courses</button>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div>
</div>
        </div>
    </div>

@include('web.layouts.footer')
@endsection
