<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">


    {{-- <link rel="stylesheet" type="text/css" href="hometemplate/css/star-rating-svg.css"> --}}


    @vite(['resources/js/app.js', 'resources/sass/app.scss'])

    <!-- Favicon -->
    <link href="hometemplate/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <!-- Libraries Stylesheet -->
    <link href="{{ url('/hometemplate/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ url('/hometemplate/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    
    {{-- <link href="hometemplate/lib/slick/slick.css" rel="stylesheet">
    <link href="hometemplate/lib/slick/slick-theme.css" rel="stylesheet"> --}}

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ url('/hometemplate/css/style.css') }}" rel="stylesheet">

    {{-- <link href="hometemplate/css/style2.css" rel="stylesheet"> --}}

    {{-- jquery cdn --}}
    <script src="https://code.jquery.com/jquery-3.6.3.js"></script>


    {{-- swiper cdn --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    

    {{-- custom css --}}
    <style>
        body {
            font-family: "iransans";
        }

        .dropdown-menu>a.nav-link.dropdown-toggle {
            display: none;
        }
    </style>
</head>

<body>

    @yield('content')





    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('/hometemplate/lib/easing/easing.min.js') }}"></script>
    <script src="{{ url('/hometemplate/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    
    {{-- sweet alert --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    @include('sweetalert::alert')


    <!-- Contact Javascript File -->
    <script src="{{ url('/hometemplate/mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ url('/hometemplate/mail/contact.js') }}"></script>


    <!-- Template Javascript -->
    <script src="{{ url('/hometemplate/js/main.js') }}"></script>
    @yield('script')
</body>

</html>
