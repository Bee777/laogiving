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
          content="Dashboard | {{ $s['site_name'] }}"/>
    <meta property="og:description"
          content="{{ $s['site_name'] }} ເວບໄຊຈັດການ ການສື່ສານລະຫວ່າງອາສາສະໝັກ ແລະອົງກອນຮັບອາສາສະໝັກ ຂອງປະເທດລາວ"/>
    <meta property="og:image" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}"/>

    <meta property="og:site_name" content="{{ $s['site_name'] }}">
    <meta property="og:image:height" content="630">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:type" content="image/png">

    <meta name="twitter:title"
          content="Dashboard | {{ $s['site_name'] }}">
    <meta name="twitter:description"
          content="{{ $s['site_name'] }} ເວບໄຊຈັດການ ການສື່ສານລະຫວ່າງອາສາສະໝັກ ແລະອົງກອນຮັບອາສາສະໝັກ ຂອງປະເທດລາວ">
    <meta name="twitter:image:src" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ $s['site_name'] }}">
    <meta name="twitter:creator" content="{{ $s['site_name'] }}">
    <meta name="twitter:image" content="{{ url('/') }}/assets/images/{{ $s['website_logo']  }}">
    <meta name="twitter:domain" content="{{ url('/') }}">

    <meta itemprop="name" content="Dashboard | {{ $s['site_name'] }}">
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
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/plugins/pickadate/themes/default.css"
          id="theme_base">
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/plugins/pickadate/themes/default.date.css"
          id="theme_date">
    <link rel="stylesheet" href="{{url('/')}}/bundles/general/assets/plugins/pickadate/themes/default.time.css"
          id="theme_time">
    <link rel="stylesheet" href="{{url('/')}}/bundles/organize/assets/css/select2.min.css">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/global.css{{$s['fresh_version']}}">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/style.css{{$s['fresh_version']}}">
    <link rel=stylesheet href="{{url('/')}}/bundles/general/assets/css/laogiving.css{{$s['fresh_version']}}">
    {{-- @GeneratedResourcesTop--}}
    {{-- @GeneratedResourcesTop--}}
@endsection
@section('scripts_footer')
    <script src="{{url('/')}}/bundles/general/assets/js/bootstrap.min.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/vendor/flexslider/jquery.flexslider-min.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/vendor/owlcarousel/owl.carousel.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/js/swiper.min.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/plugins/pickadate/picker.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/plugins/pickadate/picker.date.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/plugins/pickadate/picker.time.js"></script>
    <script src="{{url('/')}}/bundles/general/assets/plugins/pickadate/legacy.js"></script>
    <script src="{{url('/')}}/bundles/organize/assets/js/select2.min.js"></script>
    <script>
        var baseUrl = '{{ url('/') }}';
        var pathPrefix = '/';
        var baseRes = '/bundles/organize/';
        window.$ = jQuery;
    </script>
    {{-- @GeneratedResourcesBottom--}}
    <script type="text/javascript"
            src="{{url('/bundles/generated')}}/organize/organize.355b7a6d89a6f4b170b6.bundle.js"></script>
    {{-- @GeneratedResourcesBottom--}}
@endsection
