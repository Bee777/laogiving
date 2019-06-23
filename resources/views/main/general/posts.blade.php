@extends('layouts.app')
@section('g_description')Read {{ $post_type_name }} on {{ $s['site_name'] }}, Latest {{ $post_type_name }} on {{ $s['site_name'] }}
@stop
@section('g_keywords'){{ $post_type_name }},  {{ $post_type_name }} on {{ $s['site_name'] }}, Latest {{ $post_type_name }}
@stop
@section('meta_search')

    <link rel="canonical" href="{{ urldecode(url()->full()) }}">
    <meta property="og:url" content="{{ urldecode(url()->full()) }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title"
          content="{{ $post_type_name }} | {{ $s['site_name'] }}"/>
    <meta property="og:description"
          content="Read {{ $post_type_name }} on {{ $s['site_name'] }}, Latest {{ $post_type_name }} on {{ $s['site_name'] }} | {{ $s['site_name'] }}"/>
    <meta property="og:image" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}"/>

    <meta property="og:site_name" content="{{ $s['site_name'] }}">
    <meta property="og:image:height" content="630">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:type" content="image/png">

    <meta name="twitter:title"
          content="{{ $post_type_name }} | {{ $s['site_name'] }}">
    <meta name="twitter:description"
          content="Read {{ $post_type_name }} on {{ $s['site_name'] }}, Latest {{ $post_type_name }} on {{ $s['site_name'] }} | {{ $s['site_name'] }}">
    <meta name="twitter:image:src" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ $s['site_name'] }}">
    <meta name="twitter:creator" content="{{ $s['site_name'] }}">
    <meta name="twitter:image" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}">
    <meta name="twitter:domain" content="{{ url('/') }}">

    <meta itemprop="name" content="{{ $post_type_name }} | {{ $s['site_name'] }}">
    <meta itemprop="description"
          content="Read {{ $post_type_name }} on {{ $s['site_name'] }}, Latest {{ $post_type_name }} on {{ $s['site_name'] }} | {{ $s['site_name'] }}">
    <meta itemprop="image" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}">

@stop

@section('title')Latest {{ $post_type_name }}
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
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/plugins/pickadate/themes/default.css"
          id="theme_base">
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/plugins/pickadate/themes/default.date.css"
          id="theme_date">
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/plugins/pickadate/themes/default.time.css"
          id="theme_time">
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
            src="{{url('/bundles/generated')}}/general/general.d2f74f93fa7a3311c16d.bundle.js"></script>
    {{-- @GeneratedResourcesBottom--}}
@endsection

