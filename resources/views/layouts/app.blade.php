<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ setting('description') }}">

    <!-- ========== Page Title ========== -->
    <title>{{ setting('title') }}</title>

    <!-- ========== Favicon Icon ========== -->
    <link rel="shortcut icon" href="{{ Storage::url('uploads/' . setting('fav_icon')) }}" type="image/x-icon">

    <!-- ========== Start Stylesheet ========== -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/flaticon-set.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/elegant-icons.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/magnific-popup.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/owl.carousel.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/owl.theme.default.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/bootsnav.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/style.css')}}?id=1" rel="stylesheet">
    <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet"/>
    <!-- ========== End Stylesheet ========== -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{asset('assets/js/html5/html5shiv.min.js')}}"></script>
    <script src="{{asset('assets/js/html5/respond.min.js')}}"></script>
    <![endif]-->

    <!-- ========== Tajawal Google Fonts ========== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
          rel="stylesheet">

</head>

<body>

<!-- Preloader Start -->
<div class="se-pre-con"></div>
<!-- Preloader Ends -->

@include('layouts._header')

<!-- Start Login Form
============================================= -->
<form action="#" id="login-form" class="mfp-hide white-popup-block">
    <div class="col-md-4 login-social">
        <h4>Login with social</h4>
        <ul>
            <li class="facebook">
                <a href="#">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </li>
            <li class="twitter">
                <a href="#">
                    <i class="fab fa-twitter"></i>
                </a>
            </li>
            <li class="linkedin">
                <a href="#">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-8 login-custom">
        <h4>login to your registered account!</h4>
        <div class="col-md-12">
            <div class="row">
                <div class="form-group">
                    <input class="form-control" placeholder="Email*" type="email">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="form-group">
                    <input class="form-control" placeholder="Password*" type="text">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <label for="login-remember"><input type="checkbox" id="login-remember">Remember Me</label>
                <a title="Lost Password" href="#" class="lost-pass-link">Lost your password?</a>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <button type="submit">
                    Login
                </button>
            </div>
        </div>
        <p class="link-bottom">Not a member yet? <a href="#">Register now</a></p>
    </div>
</form>
<!-- End Login Form -->

<!-- Start Register Form
============================================= -->
<form action="#" id="register-form" class="mfp-hide white-popup-block">
    <div class="col-md-4 login-social">
        <h4>Register with social</h4>
        <ul>
            <li class="facebook">
                <a href="#">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </li>
            <li class="twitter">
                <a href="#">
                    <i class="fab fa-twitter"></i>
                </a>
            </li>
            <li class="linkedin">
                <a href="#">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-8 login-custom">
        <h4>Register a new account</h4>
        <div class="col-md-12">
            <div class="row">
                <div class="form-group">
                    <input class="form-control" placeholder="Email*" type="email">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="form-group">
                    <input class="form-control" placeholder="Username*" type="text">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="form-group">
                    <input class="form-control" placeholder="Password*" type="text">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="form-group">
                    <input class="form-control" placeholder="Repeat Password*" type="text">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <button type="submit">
                    Sign up
                </button>
            </div>
        </div>
        <p class="link-bottom">Are you a member? <a href="#">Login now</a></p>
    </div>
</form>
<!-- End Register Form -->

@yield('content')
<!-- Start Footer
============================================= -->
@include('layouts._footer')
<!-- End Footer -->

<!-- jQuery Frameworks
============================================= -->
<script src="{{asset('assets/js/jquery-1.12.4.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/equal-height.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.appear.js')}}"></script>
<script src="{{asset('assets/js/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/js/modernizr.custom.13711.js')}}"></script>
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/js/wow.min.js')}}"></script>
<script src="{{asset('assets/js/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('assets/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('assets/js/count-to.js')}}"></script>
<script src="{{asset('assets/js/loopcounter.js')}}"></script>
<script src="{{asset('assets/js/jquery.nice-select.min.js')}}"></script>
<script src="{{asset('assets/js/bootsnav.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>

</body>
</html>
