@extends('web.layouts.app')
@section('content')
@include('web.layouts.header')
@include('web.layouts.header-search')
 
 <!-- about school -->
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <!-- left -->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <!-- heading -->
                    <div class="col-12">
                        <h3 class="headingAbout">About School</h3> </div>
                    <!-- para -->
                    <div class="col-12">
                        <p class="text-justify eligibilityPara">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu aute dolor velit et dolor sit dolore pariatur exercitation adipiscing deserunt ea mollit Lorem aliquip in ex ad et dolor eiusmod adipiscing fugiat ullamco non. Non velit velit in id dolore elit, cupidatat tempor voluptate quis sint in pariatur laborum incididunt Ut veniam, dolore in sunt in Lorem sunt officia tempor id consequat aute ut minim dolore ullamco Lorem et in adipiscing Excepteur sed dolore. Sed sunt proident, aliqua dolore fugiat ea in est non nostrud fugiat anim nulla et velit cupidatat eu occaecat aliqua reprehenderit magna fugiat ad elit, nostrud dolor consequat laboris consectetur consequat et laborum commodo fugiat pariatur tempor dolor labore ut.</p>
                    </div>
                </div>
                <!-- right -->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <video controls playsinline id="player" class="removeBorderRadius" style="width: 100%;">
                        <!-- Video files -->
                        <source src="{{ asset('public/web/video/1.mp4') }}" type="video/mp4">
                        <!-- Caption files -->
                    </video>
                </div>
            </div>
        </div>
    </div>
    <!-- kpi + graph -->
    <div class="container-fluid ratings-container">
        <div class="container">
            <!-- first line -->
            <div class="row">
                <div class="col-12">
                    <p class="text-justify eligibilityPara">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu aute dolor velit et dolor sit dolore pariatur exercitation adipiscing deserunt ea mollit Lorem aliquip in ex ad et dolor eiusmod adipiscing fugiat ullamco non. Non velit velit in id dolore elit, cupidatat tempor voluptate quis sint in pariatur laborum incididunt Ut veniam, dolore in sunt in Lorem sunt officia tempor id consequat aute ut minim dolore ullamco Lorem et in adipiscing Excepteur sed dolore. </p>
                </div>
            </div>
            <!-- overall rating -->
            <div class="row">
                <!-- overall rating -->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-center">
                    <h4 class="overallHeading">Overall Rating</h4>
                    <p class="text-center eligibilityPara">Et deserunt esse nisi reprehenderit quis sint reprehenderit ex ex exercitation ex ut adipiscing eu aute dolor velit et dolor sit dolore pariatur exercitation adipiscing deserunt ea.</p>
                    <meter class="c-starRating" max="5" min="0" value="4"></meter>
                    <div> <img src="{{ asset('public/web/images/common/gis.png')}}" class="img-fluid ratingLogoWidth" alt="image"> <img src="{{ asset('public/web/images/common/forbes.png')}}" class="img-fluid  ratingLogoWidth" alt="image"> <img src="{{ asset('public/web/images/common/gpts-logo.png')}}" class="img-fluid  ratingLogoWidth" alt="image"> </div>
                </div>
                <!-- chart -->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 school-page-circle">
                    <!-- chart -->
                    <div class="second circle"> <strong></strong> <span>4.39</span> </div>
                </div>
            </div>
            <div class="row factor-list-box-wrapper">
                <div class="col-12 col-lg-6">
                    <div class="factor-list-box d-flex align-items-center">
                        <div class="factor-image"> <img class="img-fluid" src="{{ asset('public/web/images/common/happiness-factor.png')}}"> </div>
                        <div class="factor-text">
                            <h3 class="">HAPPINESS FACTOR</h3>
                            <p> Proident, ipsum fugiat officia. Aliqua ut ad incididunt. Voluptate Lorem Duis veniam, elit. In nulla dolore nostrud est laborum. Cupidatat laboris sint ex. Ut qui irure aute. Non adipiscing voluptate fugiat velit. Ex et ipsum pariatur. </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="factor-list-box d-flex align-items-center">
                        <div class="factor-image"> <img class="img-fluid" src="{{ asset('public/web/images/common/happiness-factor.png')}}"> </div>
                        <div class="factor-text">
                            <h3 class="">HAPPINESS FACTOR</h3>
                            <p> Proident, ipsum fugiat officia. Aliqua ut ad incididunt. Voluptate Lorem Duis veniam, elit. In nulla dolore nostrud est laborum. Cupidatat laboris sint ex. Ut qui irure aute. Non adipiscing voluptate fugiat velit. Ex et ipsum pariatur. </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="factor-list-box d-flex align-items-center">
                        <div class="factor-image"> <img class="img-fluid" src="{{ asset('public/web/images/common/happiness-factor.png')}}"> </div>
                        <div class="factor-text">
                            <h3 class="">HAPPINESS FACTOR</h3>
                            <p> Proident, ipsum fugiat officia. Aliqua ut ad incididunt. Voluptate Lorem Duis veniam, elit. In nulla dolore nostrud est laborum. Cupidatat laboris sint ex. Ut qui irure aute. Non adipiscing voluptate fugiat velit. Ex et ipsum pariatur. </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="factor-list-box d-flex align-items-center">
                        <div class="factor-image"> <img class="img-fluid" src="{{ asset('public/web/images/common/happiness-factor.png')}}"> </div>
                        <div class="factor-text">
                            <h3 class="">HAPPINESS FACTOR</h3>
                            <p> Proident, ipsum fugiat officia. Aliqua ut ad incididunt. Voluptate Lorem Duis veniam, elit. In nulla dolore nostrud est laborum. Cupidatat laboris sint ex. Ut qui irure aute. Non adipiscing voluptate fugiat velit. Ex et ipsum pariatur. </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="factor-list-box d-flex align-items-center">
                        <div class="factor-image"> <img class="img-fluid" src="{{ asset('public/web/images/common/happiness-factor.png')}}"> </div>
                        <div class="factor-text">
                            <h3 class="">HAPPINESS FACTOR</h3>
                            <p> Proident, ipsum fugiat officia. Aliqua ut ad incididunt. Voluptate Lorem Duis veniam, elit. In nulla dolore nostrud est laborum. Cupidatat laboris sint ex. Ut qui irure aute. Non adipiscing voluptate fugiat velit. Ex et ipsum pariatur. </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="factor-list-box d-flex align-items-center">
                        <div class="factor-image"> <img class="img-fluid" src="{{ asset('public/web/images/common/happiness-factor.png') }}"> </div>
                        <div class="factor-text">
                            <h3 class="">HAPPINESS FACTOR</h3>
                            <p> Proident, ipsum fugiat officia. Aliqua ut ad incididunt. Voluptate Lorem Duis veniam, elit. In nulla dolore nostrud est laborum. Cupidatat laboris sint ex. Ut qui irure aute. Non adipiscing voluptate fugiat velit. Ex et ipsum pariatur. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="college-events-container">
        <div class="container">
            <div class="row justify-content-between no-gutters">
                <h3 class="col-12 text-center">College Events</h3>
                <div class="col-4">
                    <div class="events-wrapper">
                        <div class="media"> <img class="align-self-start mr-3" src="{{ asset('public/web/images/common/gis.png') }}" alt="Generic placeholder image">
                            <div class="media-body small-text">
                                <h5 class="mt-0">Top-aligned media</h5>
                                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="events-wrapper">
                        <div class="media"> <img class="align-self-start mr-3" src="{{ asset('public/web/images/common/gis.png') }}" alt="Generic placeholder image">
                            <div class="media-body small-text">
                                <h5 class="mt-0">Top-aligned media</h5>
                                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="events-wrapper">
                        <div class="media"> <img class="align-self-start mr-3" src="{{ asset('public/web/images/common/gis.png') }}" alt="Generic placeholder image">
                            <div class="media-body small-text">
                                <h5 class="mt-0">Top-aligned media</h5>
                                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="events-wrapper">
                        <div class="media"> <img class="align-self-start mr-3" src="{{ asset('public/web/images/common/gis.png') }}" alt="Generic placeholder image">
                            <div class="media-body small-text">
                                <h5 class="mt-0">Top-aligned media</h5>
                                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="events-wrapper">
                        <div class="media"> <img class="align-self-start mr-3" src="{{ asset('public/web/images/common/gis.png') }}" alt="Generic placeholder image">
                            <div class="media-body small-text">
                                <h5 class="mt-0">Top-aligned media</h5>
                                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="events-wrapper">
                        <div class="media"> <img class="align-self-start mr-3" src="{{ asset('public/web/images/common/gis.png') }}" alt="Generic placeholder image">
                            <div class="media-body small-text">
                                <h5 class="mt-0">Top-aligned media</h5>
                                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contact-details-container blue-font">
        <div class="container">
            <div class="row">
                <h2 class="col-12 text-center medium-text">
               Contact Details
           </h2>
                <div class="col-6">
                    <div class="address-details">
                        <h3 class="details-head">Address</h3>
                        <p class="institute-name"> Srishti School or Art Design and Technology </p>
                        <p class="institute-address"> No. 40/D, 2nd Cross, 5th Main Marilingiah Building Shiva Mandir Road</p>
                        <p class="institute-address">(Near 5th Phase Bus Stop), KHB Indutstrial Area, Yelahanka, Bangalore 560 106, India</p>
                    </div>
                    <div class="contact-details">
                        <h3 class="details-head">Contact Number</h3>
                        <p class="institute-number">+91 - 80 49000800 / 49000801 / 2 /3 /4 </p>
                        <p class="website-details"> <span>www.srishti.ac.in</span><span>  | 
                    </span><span>admissions@srishti.ac.in / marketing@srishti.ac.in</span> </p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mapouter">
                        <div class="gmap_canvas">
                            <iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=university%20of%20san%20francisco&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.pureblack.de">website erstellen lassen</a></div>
                        <style>
                            .mapouter {
                                text-align: right;
                                height: 200px;
                                width: 100%;
                            }
                            
                            .gmap_canvas {
                                overflow: hidden;
                                background: none!important;
                                height: 200px;
                                width: 100%;
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- placements -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3 class="headingThree text-center">Placements</h3>
                <p class="subP text-center">Proident, ipsum fugiat officia. Aliqua ut ad incididunt. Voluptate Lorem Duis veniam, elit.</p>
            </div>
            <div class="col-12">
                <div class="gptsCertified">
                    <div>
                        <div class="boxCertified"> <img src="{{ asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{ asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{ asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{ asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{ asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{ asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{ asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{ asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{ asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
                    </div>
                    <div>
                        <div class="boxCertified"> <img src="{{ asset('public/web/images/common/schoolicon.png')}}" class="img-fluid center-block" alt="image"> </div>
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
