@extends('layouts.app')
@section('title', 'Home')
@section('g_description')ເວບໄຊຈັດການ ການສື່ສານລະຫວ່າງອາສາສະໝັກ ແລະອົງກອນຮັບອາສາສະໝັກ ຂອງປະເທດລາວ@stop
@section('g_keywords')communicate between Volunteers and Organizations, Volunteers, Organizations, ອາສາສະໝັກ, ອົງກອນຮັບອາສາສະໝັກ, ການສື່ສານລະຫວ່າງອາສາສະໝັກ ແລະອົງກອນຮັບອາສາສະໝັກ, ເວບໄຊຈັດການ ການສື່ສານລະຫວ່າງອາສາສະໝັກ ແລະອົງກອນຮັບອາສາສະໝັກ ຂອງປະເທດລາວ
@stop
@section('meta_search')

    <link rel="canonical" href="{{ urldecode(url()->full()) }}">
    <meta property="og:url" content="{{ urldecode(url()->full()) }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title"
          content="Home | {{ $s['site_name'] }}"/>
    <meta property="og:description"
          content="{{ $s['site_name'] }} ເວບໄຊຈັດການ ການສື່ສານລະຫວ່າງອາສາສະໝັກ ແລະອົງກອນຮັບອາສາສະໝັກ ຂອງປະເທດລາວ"/>
    <meta property="og:image" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}"/>

    <meta property="og:site_name" content="{{ $s['site_name'] }}">
    <meta property="og:image:height" content="630">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:type" content="image/png">

    <meta name="twitter:title"
          content="Home | {{ $s['site_name'] }}">
    <meta name="twitter:description"
          content="{{ $s['site_name'] }} ເວບໄຊຈັດການ ການສື່ສານລະຫວ່າງອາສາສະໝັກ ແລະອົງກອນຮັບອາສາສະໝັກ ຂອງປະເທດລາວ">
    <meta name="twitter:image:src" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ $s['site_name'] }}">
    <meta name="twitter:creator" content="{{ $s['site_name'] }}">
    <meta name="twitter:image" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}">
    <meta name="twitter:domain" content="{{ url('/') }}">

    <meta itemprop="name" content="Home | {{ $s['site_name'] }}">
    <meta itemprop="description"
          content="{{ $s['site_name'] }} ເວບໄຊຈັດການ ການສື່ສານລະຫວ່າງອາສາສະໝັກ ແລະອົງກອນຮັບອາສາສະໝັກ ຂອງປະເທດລາວ">
    <meta itemprop="image" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}">
@stop
@section('scripts_header')
    <link rel="stylesheet" href="{{url('/')}}/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="{{url('/')}}/css/general.css{{$s['fresh_version']}}">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/bootstrap.min.css">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/linearicons-free.css">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/animate.css">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/vendor/flexslider/flexslider.css">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/vendor/owlcarousel/owl.carousel.css">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/swiper.min.css">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/vendor/fancybox/css/fancybox.css">

    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/plugins/pickadate/themes/classic.css" id="theme_base">
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/plugins/pickadate/themes/classic.date.css" id="theme_date">
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/plugins/pickadate/themes/classic.time.css" id="theme_time">

    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/global.css{{$s['fresh_version']}}">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/style.css{{$s['fresh_version']}}">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/laogiving.css{{$s['fresh_version']}}">
    {{-- @GeneratedResourcesTop--}}
    {{-- @GeneratedResourcesTop--}}
@endsection
@section('scripts_footer')
    @include('main.general.defaultData')
    <script src="{{url('/')}}/bundles/general/assets/js/bootstrap.min.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/vendor/flexslider/jquery.flexslider-min.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/vendor/owlcarousel/owl.carousel.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/js/swiper.min.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/plugins/pickadate/picker.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/plugins/pickadate/picker.date.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/plugins/pickadate/picker.time.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/plugins/pickadate/legacy.js"></script>
    <script>
        jQuery.noConflict();
        jQuery(document).ready(function ($) {
            var owl = $("#owl-classes");
            owl.owlCarousel({
                items: 3, //10 items above 1000px browser width
                itemsDesktop: [1000, 3], //5 items between 1000px and 901px
                itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
                itemsTablet: [640, 2],
                itemsMobile: [480, 1], // itemsMobile disabled - inherit from itemsTablet option
                navigation: false,
                pagination: true,
                autoPlay: true
            });

            var owl = $("#owl-teachers");

            owl.owlCarousel({

                items: 2, //10 items above 1000px browser width
                itemsDesktop: [1000, 2], //5 items between 1000px and 901px
                itemsDesktopSmall: [900, 2], // 3 items betweem 900px and 601px
                itemsTablet: [600, 1],
                itemsMobile: [480, 1], // itemsMobile disabled - inherit from itemsTablet option
                navigation: false,
                pagination: true,
                autoPlay: true
            });

        });
    </script>
    <script src={{url('/')}}/bundles/general/assets/js/theme.js></script>
    <script src={{url('/')}}/bundles/general/assets/vendor/fancybox/js/jquery.fancybox.js></script>
    <script src={{url('/')}}/bundles/general/assets/vendor/fancybox/js/custom.fancybox.js></script>
    <script>
        jQuery.noConflict();
        jQuery('.fancybox').fancybox();
    </script>
    <script src={{url('/')}}/bundles/general/assets/js/wow.min.js></script>
    <script>
        new WOW().init();
        var baseRes = '/bundles/general/';
        window.$ = jQuery;
    </script>
    {{-- @GeneratedResourcesBottom--}}
    <script type="text/javascript"
            src="{{url('/bundles/generated/general')}}/general.a6316df0399ab698fd58.bundle.js"></script>
    {{-- @GeneratedResourcesBottom--}}
@endsection
