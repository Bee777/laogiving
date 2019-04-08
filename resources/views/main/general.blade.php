@extends('layouts.app')
@section('title', 'Home')
@section('scripts_header')
    <link rel="stylesheet" href="{{url('/')}}/css/general.css{{$s['fresh_version']}}">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/bootstrap.min.css">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/linearicons-free.css">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/animate.css">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/vendor/flexslider/flexslider.css">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/vendor/owlcarousel/owl.carousel.css">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/vendor/fancybox/css/fancybox.css">
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
            src="{{url('/bundles/generated')}}/general/general.9509a85eeccc8b7bd7ad.bundle.js"></script>
    {{-- @GeneratedResourcesBottom--}}
@endsection
