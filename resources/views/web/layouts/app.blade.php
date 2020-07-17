<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GPTS') }}</title>
    <!-- Fonts -->
	<link href="{{ asset('public/web/plugins/fontawesome-free-5.2.0-web/css/all.css') }}" rel="stylesheet">
	<link href="{{ asset('public/web/videoPlayer/plyr.css') }}" rel="stylesheet">
	<link href="{{ asset('public/web/plugins/slick-1.8.1/slick/slick.css') }}" rel="stylesheet">
    <!-- Styles -->
	<link href="{{ asset('public/web/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/web/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('public/web/css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('public/web/css/homepage.css') }}" rel="stylesheet">
    <link href="{{ asset('public/web/css/career-discovery.css') }}" rel="stylesheet">
    <link href="{{ asset('public/web/css/comparison.css') }}" rel="stylesheet">
    <link href="{{ asset('public/web/css/pricing.css') }}" rel="stylesheet">
    <link href="{{ asset('public/web/css/student-login.css') }}" rel="stylesheet">
    <link href="{{ asset('public/web/css/footer.css') }}" rel="stylesheet">
</head>
<body>
   
    @yield('content')

   <!-- Scripts -->
	<script src="{{ asset('public/web/js/jquery-3.3.1.min.js') }}"></script>
	<script src="{{ asset('public/web/js/bootstrap.js') }}"></script>
	<script src="{{ asset('public/web/js/popper.min.js') }}"></script>
	<script src="{{ asset('public/web/plugins/videoPlayer/polyfill.js') }}"></script>
	<script src="{{ asset('public/web/videoPlayer/plyr.polyfilled.js') }}"></script>
	<script src="{{ asset('public/web/plugins/slick-1.8.1/slick/slick.min.js') }}" ></script>
	<script src="{{ asset('public/web/js/swiper.min.js') }}"></script>
	<script src="{{ asset('public/web/js/common.js') }}"></script>
	<script src="{{ asset('public/web/js/app.js') }}"></script>
	<script>
    $('.videoSlider').slick({
        dots: false
        , infinite: false
        , arrow: false
        , variableWidth: false
        , speed: 1000
        , slidesToShow: 3
        , slidesToScroll: 1
        , prevArrow: null
        , nextArrow: null
        , autoplay: false
        , cssEase: 'cubic-bezier(.33,0.35,.22,-0.50)'
        , responsive: [
            {
                breakpoint: 1024
                , settings: {
                    slidesToShow: 2
                    , slidesToScroll: 1
                    , infinite: true
                    , dots: false
                }
    }
        , {
                breakpoint: 600
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                }
    }
        , {
                breakpoint: 480
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
    });
</script>
<!-- testimonial -->
<script>
    $('.testimonial').slick({
        dots: false
        , infinite: false
        , arrow: true
        , variableWidth: false
        , speed: 1000
        , slidesToShow: 1
        , slidesToScroll: 1
        , prevArrow: null
        , nextArrow: null
        , autoplay: true
        , cssEase: 'cubic-bezier(.33,0.35,.22,-0.50)'
        , responsive: [
            {
                breakpoint: 1024
                , settings: {
                    slidesToShow: 2
                    , slidesToScroll: 1
                    , infinite: true
                    , dots: false
                }
    }
        , {
                breakpoint: 600
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                }
    }
        , {
                breakpoint: 480
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
    });
</script>
<!-- gpts c ertified -->
<script>
    $('.gptsCertified').slick({
        dots: false
        , infinite: true
        , arrows: true
        , variableWidth: false
        , speed: 1000
        , slidesToShow: 8
        , slidesToScroll: 1
        , prevArrow: null
        , nextArrow: null
        , autoplay: true
        , cssEase: 'cubic-bezier(.33,0.35,.22,-0.50)'
        , responsive: [
            {
                breakpoint: 1024
                , settings: {
                    slidesToShow: 4
                    , slidesToScroll: 1
                    , infinite: true
                    , dots: false
                }
    }
        , {
                breakpoint: 600
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                }
    }
        , {
                breakpoint: 480
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
    });
</script>
<!-- checkbox image -->
<script type="text/javascript">
    jQuery(function ($) {
        // init the state from the input
        $(".image-checkbox").each(function () {
            if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
                $(this).addClass('image-checkbox-checked');
            }
            else {
                $(this).removeClass('image-checkbox-checked');
            }
        });
        // sync the state to the input
        $(".image-checkbox").on("click", function (e) {
            if ($(this).hasClass('image-checkbox-checked')) {
                $(this).removeClass('image-checkbox-checked');
                $(this).find('input[type="checkbox"]').first().removeAttr("checked");
            }
            else {
                $(this).addClass('image-checkbox-checked');
                $(this).find('input[type="checkbox"]').first().attr("checked", "checked");
            }
            e.preventDefault();
        });
    });
</script>
<!-- fees range selector -->
<script>
    (function () {
        var parent = document.querySelector(".range-slider");
        if (!parent) return;
        var rangeS = parent.querySelectorAll("input[type=range]")
            , numberS = parent.querySelectorAll("input[type=number]");
        rangeS.forEach(function (el) {
            el.oninput = function () {
                var slide1 = parseFloat(rangeS[0].value)
                    , slide2 = parseFloat(rangeS[1].value);
                if (slide1 > slide2) {
				[slide1, slide2] = [slide2, slide1];
                    // var tmp = slide2;
                    // slide2 = slide1;
                    // slide1 = tmp;
                }
                numberS[0].value = slide1;
                numberS[1].value = slide2;
            }
        });
        numberS.forEach(function (el) {
            el.oninput = function () {
                var number1 = parseFloat(numberS[0].value)
                    , number2 = parseFloat(numberS[1].value);
                if (number1 > number2) {
                    var tmp = number1;
                    numberS[0].value = number2;
                    numberS[1].value = tmp;
                }
                rangeS[0].value = number1;
                rangeS[1].value = number2;
            }
        });
    })();
</script>
<!-- circle progress -->
<script src="{{ asset('public/web/plugins/circleProgress/circle-progress.js') }}"></script>
<script>
    $('.second.circle').circleProgress({
        value: 0.6
    }).on('circle-animation-progress', function (event, progress) {
        $(this).find('strong').html(Math.round(100 * progress) + '<i>%</i>');
    });
</script>
</body>
</html>
