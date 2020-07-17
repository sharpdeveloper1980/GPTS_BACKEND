@extends('web.layouts.app')
@section('content')
@include('web.layouts.header')
@include('web.layouts.header-search')
    <!-- navigation ends -->
    <div class="career-discovery-conatiner container-top container-fluid">
        <div class="text-center">
            <h2 class="big-text blue-font header-text">Career Discovery</h2>
        </div>
        <div class="career-discovery-agree-wrapper mx-auto text-center row flex-column align-items-center">
            <div class="career-discover-logo col-4">
                <img class="w-100" src="{{ asset('public/web/images/common/career-discovery-log.png')}}">
            </div>
            <h4 class="orange-font medium-text text-center col-12">A LITTLE SURVEY TO UNDERSTAND
             WHAT KIND OF CAREER WILL SUIT YOU</h4>
            <p class="genral-text text-center blue-font col-12">
                Our Lifestyle Assessment will determine what salary you should aim to earn to support your lifestyle. This salary figure, along with the results of your Career Assessment, allows us to pinpoint career recommendations for your individual lifestyle and career interests.
            </p>
            <button class="primary-button rounded-0 col-4">AGREE</button>
        </div>
    </div>
@include('web.layouts.footer')
@endsection
