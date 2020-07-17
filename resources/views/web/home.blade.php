@extends('web.layouts.app')
@section('content')
@include('web.layouts.header')
@include('web.layouts.header-search')
    <!-- navigation ends -->
    <div class="homepage-conatiner">
        <div class="poster-video-conatiner position-relative">
            <img class="poster-image" src="{{ asset('public/web/images/homepage/header-image.png') }}">
            <div class="position-absolute poster-text-wrapper">
                <div class="big-text text-white">RJ Ronak</div>
                <div class="medium-text text-white">Radio 93.5 red FM</div>
                <div class="poster-sub-text">
                    <div class="medium-text text-white">Education is the most powerful weapon</div>
                    <div class="small-text text-white">Elit, enim dolore magna. In culpa magna aute amet, voluptate. Sunt quis laboris labore labore.</div>
                </div>
                <div class="poster-video-controls d-flex align-items-center justify-content-center">
                    <button class="transparent-button d-inline-block">Play Video</button>
                    <div class="voice-control d-inline-block"></div>
                </div>
            </div>
            <div class="search-form position-absolute">
                <form class="d-flex">
                    <input class="d-inline-block" type="text" name="search" placeholder="Enter your preference here">
                    <button class="d-inline-block text-white small-text submit-button">Search</button>
                </form>
            </div>
        </div>
        <div class="scroll-down-container text-center">
            <img src="{{ asset('public/web/images/homepage/down-ellipse.png') }}">
            <div class="blue-font extra-small-text">SCROLL DOWN FOR MORE</div>
        </div>
        <div class="what-we-do-wrapper blue-font">
            <div class="blue-font big-text text-center semi-bold">
                What we do
            </div>
            <div class="genral-text text-center">
                Elit, enim dolore magna. In culpa magna aute amet, voluptate. Sunt quis laboris labore labore.
            </div>
            <div class="container-fluid  what-we-do-info-wrapper">
                <div class="row">
                    <div class="col-12 col-lg-3 text-center">
                        <img class="mw-100" src="{{ asset('public/web/images/homepage/career-search.png') }}">
                        <div class="medium-text semi-bold what-we-do-head">Career Search</div>
                        <div class="small-text what-we-do-info">Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute.</div>
                        <a class="link genral-text semi-bold d-inline-block" href="#">Start Now</a>
                    </div>
                    <div class="col-12 col-lg-3 text-center">
                        <img class="mw-100" src="{{ asset('public/web/images/homepage/common-app-form.png') }}">
                        <div class="medium-text semi-bold what-we-do-head">Career Discovery</div>
                        <div class="small-text what-we-do-info">Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute.</div>
                        <a class="link genral-text semi-bold d-inline-block" href="#">Start Now</a>
                    </div>
                    <div class="col-12 col-lg-3 text-center">
                        <img class="mw-100" src="{{ asset('public/web/images/homepage/common-app-form.png') }}">
                        <div class="medium-text semi-bold what-we-do-head">College Search</div>
                        <div class="small-text what-we-do-info">Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute.</div>
                        <a class="link genral-text semi-bold d-inline-block" href="#">Start Now</a>
                    </div>
                    <div class="col-12 col-lg-3 text-center">
                        <img class="mw-100" src="{{ asset('public/web/images/homepage/college-search.png') }}">
                        <div class="medium-text semi-bold what-we-do-head">College Search</div>
                        <div class="small-text what-we-do-info">Laborum ut ad proident, dolor reprehenderit. Sunt non Lorem eu. Dolor consequat dolore in esse cupidatat. Ut in ut sed in aute.</div>
                        <a class="link genral-text semi-bold d-inline-block" href="#">Start Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('web.layouts.footer')
@endsection
