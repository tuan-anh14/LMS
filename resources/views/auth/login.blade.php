<!DOCTYPE html>
<html class="light-layout loaded" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
  data-textdirection="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" data-layout="bordered-layout">
<!-- BEGIN: Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description"
    content="Educational Learning Management System - Access your courses and manage your learning journey">
  <meta name="keywords"
    content="LMS, education, learning, courses, online education, student portal">
  <meta name="author" content="LMS Education Center">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="loading" content="@lang('site.loading')">
  <meta name="no-data-found" content="@lang('site.no_data_found')">
  <meta name="drop-images-text" content="@lang('site.drop_images')">
  <meta name="delete-text" content="@lang('site.delete')">
  @if(setting('fav_icon'))
  <link rel="icon" type="image/x-icon" href="{{ Storage::url('uploads/' . setting('fav_icon')) }}">
  @else
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  @endif

  <title>{{ setting('title') }} - @lang('site.login')</title>

    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

  <!-- Google Fonts for Educational Theme -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- BEGIN: Vendor CSS-->
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin_assets/app-assets/vendors/js/noty/noty.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/vendors/css/forms/select/select2.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
  <!-- END: Vendor CSS-->

  {{--Vendor js--}}
  <script src="{{ asset('admin_assets/app-assets/vendors/js/vendors.min.js') }}"></script>
  <script src="{{ asset('admin_assets/app-assets/vendors/js/noty/noty.min.js') }}"></script>
  <script src="{{ asset('admin_assets/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
  <link rel="stylesheet"
    href="{{ asset('admin_assets/app-assets/vendors/css/easy-autocomplete/easy-autocomplete.min.css') }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

  {{--dropzone--}}
  <link rel="stylesheet" href="{{ asset('admin_assets/app-assets/vendors/js/dropzone/dropzone.min.css') }}">
  <script src="{{ asset('admin_assets/app-assets/vendors/js/dropzone/dropzone.min.js') }}"></script>

  {{--jstree--}}
  <link rel="stylesheet" href="{{ asset('admin_assets/app-assets/vendors/css/extensions/jstree.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/css/plugins/extensions/ext-component-tree.css') }}">
  <script src="{{ asset('admin_assets/app-assets/vendors/js/extensions/jstree.min.js') }}"></script>

  {{--fontawesome--}}
  <link rel="stylesheet" href="{{ asset('admin_assets/app-assets/fonts/font-awesome/css/font-awesome.min.css') }}">

  <!-- BEGIN: Theme CSS-->
  @if (app()->getLocale() == 'ar')

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/vendors/css/vendors-rtl.min.css') }}">

  <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css-rtl/bootstrap.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/css-rtl/bootstrap-extended.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css-rtl/colors.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/css-rtl/components.css') }}?id=1">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/css-rtl/themes/dark-layout.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/css-rtl/themes/bordered-layout.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/css-rtl/themes/semi-dark-layout.css') }}">

  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">

  <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css-rtl/custom-rtl.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/css-rtl/plugins/forms/form-validation.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/css-rtl/pages/page-auth.css') }}">

  @else
  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/vendors/css/vendors.min.css') }}">

  <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css/bootstrap.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css/bootstrap-extended.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css/colors.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css/components.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css/themes/dark-layout.css') }}">

  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">

  <link rel="stylesheet" type="text/css"
    href="{{ asset('admin_assets/app-assets/css/plugins/forms/form-wizard.css') }}">

  @endif

  <script src="{{ asset('admin_assets/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

  <link rel="stylesheet" href="{{ mix('admin_assets/app.min.css') }}">

  <!-- Educational LMS Login Styles -->
  <style>
    :root {
      /* Educational LMS Color Palette */
      --primary-blue: #1e3e7a;
      --primary-dark: #002147;
      --secondary-teal: #0e8c9a;
      --accent-light: #edf2f7;
      --success-green: #28c76f;
      --info-cyan: #00cfe8;
      --warning-orange: #ff9f43;
      --danger-red: #ea5455;

      /* Educational Gradients */
      --education-gradient: linear-gradient(135deg, #1e3e7a 0%, #002147 50%, #0e8c9a 100%);
      --light-gradient: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
      --card-gradient: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);

      /* Shadows and Effects */
      --primary-shadow: 0 10px 40px rgba(30, 62, 122, 0.15);
      --card-shadow: 0 20px 60px rgba(0, 33, 71, 0.08);
      --button-shadow: 0 8px 30px rgba(30, 62, 122, 0.3);

      /* Typography */
      --heading-font: 'Poppins', 'Tajawal', sans-serif;
      --body-font: 'Inter', 'Tajawal', sans-serif;
    }

    /* Educational Background Pattern */
    .education-login-wrapper {
      min-height: 100vh;
      background: var(--education-gradient);
      position: relative;
      overflow: hidden;
      font-family: var(--body-font);
    }

    /* Educational Pattern Overlay */
    .education-login-wrapper::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image:
        radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
        linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.03) 50%, transparent 70%);
      background-size: 300px 300px, 200px 200px, 100px 100px;
      animation: educationFloat 20s linear infinite;
    }

    @keyframes educationFloat {
      0% {
        transform: translate(0, 0) rotate(0deg);
      }

      100% {
        transform: translate(-50px, -50px) rotate(360deg);
      }
    }

    /* Decorative Educational Elements */
    .education-elements {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: 1;
    }

    .education-element {
      position: absolute;
      opacity: 0.1;
      color: rgba(255, 255, 255, 0.2);
      font-size: 24px;
      animation: floatEducation 15s ease-in-out infinite;
    }

    .education-element:nth-child(1) {
      top: 20%;
      left: 10%;
      animation-delay: 0s;
    }

    .education-element:nth-child(2) {
      top: 30%;
      right: 15%;
      animation-delay: 3s;
    }

    .education-element:nth-child(3) {
      bottom: 40%;
      left: 20%;
      animation-delay: 6s;
    }

    .education-element:nth-child(4) {
      bottom: 20%;
      right: 25%;
      animation-delay: 9s;
    }

    .education-element:nth-child(5) {
      top: 60%;
      left: 50%;
      animation-delay: 12s;
    }

    @keyframes floatEducation {

      0%,
      100% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0.1;
      }

      50% {
        transform: translateY(-30px) rotate(180deg);
        opacity: 0.2;
      }
    }

    /* Modern Educational Card */
    .education-card {
      background: var(--card-gradient);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 24px;
      box-shadow: var(--card-shadow);
      padding: 48px 40px;
      max-width: 480px;
      width: 100%;
      position: relative;
      z-index: 10;
      animation: slideUpEducation 0.8s ease-out;
      overflow: hidden;
    }

    .education-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--education-gradient);
      border-radius: 24px 24px 0 0;
    }

    @keyframes slideUpEducation {
      from {
        opacity: 0;
        transform: translateY(50px) scale(0.9);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    /* Educational Logo Section */
    .education-logo {
      text-align: center;
      margin-bottom: 40px;
      position: relative;
    }

    .education-logo img {
      height: 70px;
      max-width: 220px;
      filter: drop-shadow(0 4px 12px rgba(30, 62, 122, 0.2));
      transition: all 0.3s ease;
    }

    .education-logo:hover img {
      transform: scale(1.05);
      filter: drop-shadow(0 6px 16px rgba(30, 62, 122, 0.3));
    }

    /* Educational Welcome Section */
    .education-welcome {
      text-align: center;
      margin-bottom: 40px;
    }

    .education-welcome h1 {
      font-family: var(--heading-font);
      font-weight: 700;
      font-size: 2rem;
      color: var(--primary-dark);
      margin-bottom: 12px;
      background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-teal) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .education-welcome p {
      color: #718096;
      font-size: 16px;
      font-weight: 400;
      margin: 0;
      line-height: 1.6;
    }

    /* Modern Educational Form Fields */
    .education-field {
      position: relative;
      margin-bottom: 28px;
    }

    .education-input {
      width: 100%;
      border: 2px solid #e2e8f0;
      border-radius: 16px;
      padding: 18px 24px;
      font-size: 16px;
      font-family: var(--body-font);
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.9);
      color: var(--primary-dark);
    }

    .education-input:focus {
      border-color: var(--primary-blue);
      box-shadow: 0 0 0 4px rgba(30, 62, 122, 0.1);
      outline: none;
      background: rgba(255, 255, 255, 1);
      transform: translateY(-2px);
    }

    .education-label {
      position: absolute;
      top: 50%;
      left: 24px;
      transform: translateY(-50%);
      color: #9ca3af;
      font-size: 16px;
      font-weight: 400;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      pointer-events: none;
      background: transparent;
      font-family: var(--body-font);
      z-index: 1;
      line-height: 1;
    }

    .education-input:focus+.education-label,
    .education-field.has-value .education-label {
      top: -10px;
      left: 16px;
      font-size: 13px;
      font-weight: 500;
      color: var(--primary-blue);
      background: #ffffff;
      padding: 2px 6px;
      border-radius: 4px;
      transform: translateY(0);
      box-shadow: none;
    }

    /* Improved focus state */
    .education-input:focus+.education-label {
      color: var(--secondary-teal);
    }

    /* Enhanced visual hierarchy */
    .education-field.focused .education-label {
      font-weight: 600;
    }

    /* Field styling */
    .education-field {
      position: relative;
    }

    /* Better label background for contrast */
    .education-input:focus+.education-label,
    .education-field.has-value .education-label {
      background: linear-gradient(to bottom, transparent 0%, #ffffff 20%, #ffffff 80%, transparent 100%);
    }

    /* Password Toggle */
    .password-toggle {
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #a0aec0;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 18px;
    }

    .password-toggle:hover {
      color: var(--primary-blue);
      transform: translateY(-50%) scale(1.1);
    }

    /* Educational Checkbox */
    .education-checkbox {
      display: flex;
      align-items: center;
      margin-bottom: 32px;
      gap: 12px;
    }

    .education-checkbox input[type="checkbox"] {
      width: 20px;
      height: 20px;
      accent-color: var(--primary-blue);
      border-radius: 6px;
    }

    .education-checkbox label {
      color: #4a5568;
      font-size: 15px;
      font-weight: 500;
      cursor: pointer;
      user-select: none;
    }

    /* Educational Login Button */
    .education-btn {
      width: 100%;
      background: var(--education-gradient);
      border: none;
      border-radius: 16px;
      padding: 18px 24px;
      color: white;
      font-size: 16px;
      font-weight: 600;
      font-family: var(--body-font);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      text-transform: uppercase;
      letter-spacing: 1px;
      cursor: pointer;
    }

    .education-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }

    .education-btn:hover::before {
      left: 100%;
    }

    .education-btn:hover {
      transform: translateY(-3px);
      box-shadow: var(--button-shadow);
    }

    .education-btn:active {
      transform: translateY(-1px);
    }

    /* Educational Divider */
    .education-divider {
      text-align: center;
      margin: 40px 0;
      position: relative;
    }

    .education-divider::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(to right, transparent, #e2e8f0, transparent);
    }

    .education-divider-text {
      background: linear-gradient(to right, #ffffff 0%, #f8fafc 50%, #ffffff 100%);
      padding: 0 24px;
      color: #718096;
      font-size: 14px;
      font-weight: 500;
    }

    /* Educational Social Links */
    .education-social {
      display: flex;
      justify-content: center;
      gap: 16px;
      flex-wrap: wrap;
    }

    .education-social-btn {
      width: 52px;
      height: 52px;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      border: 2px solid #e2e8f0;
      background: rgba(255, 255, 255, 0.9);
      color: #718096;
      text-decoration: none;
      font-size: 18px;
    }

    .education-social-btn:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
      color: white;
    }

    .education-social-btn.facebook:hover {
      background: #4267B2;
      border-color: #4267B2;
    }

    .education-social-btn.instagram:hover {
      background: #E4405F;
      border-color: #E4405F;
    }

    .education-social-btn.youtube:hover {
      background: #FF0000;
      border-color: #FF0000;
    }

    .education-social-btn.tiktok:hover {
      background: #000000;
      border-color: #000000;
    }

    .education-social-btn.linkedin:hover {
      background: #0077B5;
      border-color: #0077B5;
    }

    .education-social-btn.github:hover {
      background: #333333;
      border-color: #333333;
    }

    .education-social-btn.whatsapp:hover {
      background: #25D366;
      border-color: #25D366;
    }

    /* RTL Support for Arabic */
    [dir="rtl"] {
      font-family: 'Tajawal', 'Cairo', 'Poppins', sans-serif;
    }

    [dir="rtl"] .education-label {
      left: auto;
      right: 24px;
    }

    [dir="rtl"] .education-input:focus+.education-label,
    [dir="rtl"] .education-field.has-value .education-label {
      left: auto;
      right: 16px;
    }

    [dir="rtl"] .password-toggle {
      left: 20px;
      right: auto;
    }

    [dir="rtl"] .education-checkbox {
      flex-direction: row-reverse;
    }

    [dir="rtl"] .education-welcome h1 {
      font-family: 'Tajawal', sans-serif;
      font-weight: 700;
    }

    [dir="rtl"] .education-welcome p {
      font-family: 'Tajawal', sans-serif;
    }

    /* Mobile Responsive Design */
    @media (max-width: 768px) {
      .education-card {
        padding: 32px 24px;
        margin: 20px;
        max-width: 100%;
      }

      .education-welcome h1 {
        font-size: 1.75rem;
      }

      .education-social {
        gap: 12px;
      }

      .education-social-btn {
        width: 48px;
        height: 48px;
        font-size: 16px;
      }

      .education-logo img {
        height: 60px;
      }
    }

    @media (max-width: 480px) {
      .education-card {
        padding: 24px 20px;
        border-radius: 20px;
      }

      .education-welcome h1 {
        font-size: 1.5rem;
      }

      .education-input {
        padding: 16px 20px;
        font-size: 15px;
      }

      .education-btn {
        padding: 16px 20px;
        font-size: 15px;
      }
    }

    /* Loading Animation */
    .education-loading {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: #ffffff;
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    /* Error States */
    .education-field.error .education-input {
      border-color: var(--danger-red);
      box-shadow: 0 0 0 4px rgba(234, 84, 85, 0.1);
    }

    .education-field.error .education-label {
      color: var(--danger-red);
    }
  </style>

  @stack('styles')
</head>

<!-- BEGIN: Body-->

<body class="education-login-wrapper">

  <!-- Educational Background Elements -->
  <div class="education-elements">
    <div class="education-element">📚</div>
    <div class="education-element">🎓</div>
    <div class="education-element">📖</div>
    <div class="education-element">✏️</div>
    <div class="education-element">🔬</div>
  </div>

  <!-- Main Login Content -->
  <div class="d-flex align-items-center justify-content-center min-vh-100 position-relative">
    <div class="education-card">

      <!-- Educational Logo Section -->
      <div class="education-logo">
        <a href="{{route('/')}}" class="d-block">
          <img src="{{ asset('images/lms-logo.png') }}" alt="LMS Educational Center" class="img-fluid">
        </a>
      </div>

                            <div class="text-center">
                                <!-- <img src="{{ asset('images/lms-logo.png') }}" alt=""> -->
                                <h4 class="card-title my-1">@lang('site.login')</h4>
                            </div>

      <!-- Educational Login Form -->
      <form action="{{ route('login') }}" method="POST" id="education-login-form">
        @csrf
        @method('post')

        @include('admin.partials._errors')

        <!-- Email Field -->
        <div class="education-field">
          <input
            type="email"
            name="email"
            id="education-email"
            class="education-input"
            autocomplete="off"
            autofocus
            required>
          <label for="education-email" class="education-label">@lang('users.email')</label>
        </div>

        <!-- Password Field -->
        <div class="education-field">
          <input
            type="password"
            name="password"
            id="education-password"
            class="education-input"
            autocomplete="new-password"
            required>
          <label for="education-password" class="education-label">@lang('users.password')</label>
          <button type="button" class="password-toggle" onclick="toggleEducationPassword()">
            <i class="fa fa-eye" id="education-password-icon"></i>
          </button>
        </div>

        <!-- Remember Me -->
        <div class="education-checkbox">
          <input type="checkbox" name="remember_me" id="education-remember">
          <label for="education-remember">@lang('site.remember_me')</label>
        </div>

        <!-- Educational Login Button -->
        <button type="submit" class="education-btn" id="education-submit-btn">
          <span class="btn-text">@lang('site.login')</span>
          <span class="btn-loading" style="display: none;">
            <span class="education-loading"></span>
            {{ app()->getLocale() == 'ar' ? 'جاري تسجيل الدخول...' : 'Signing in...' }}
          </span>
        </button>
      </form>

      <!-- Educational Divider -->
      <div class="education-divider">
        <div class="education-divider-text">@lang('site.visit_social_media')</div>
      </div>

      <!-- Educational Social Links -->
      <div class="education-social">
        <a href="https://www.facebook.com/profile.php?id=100006448386433"
          class="education-social-btn facebook"
          target="_blank"
          title="Facebook"
          rel="noopener noreferrer">
          <i class="fab fa-facebook-f"></i>
        </a>

        <a href="https://www.instagram.com/mohammed_salahia/"
          class="education-social-btn instagram"
          target="_blank"
          title="Instagram"
          rel="noopener noreferrer">
          <i class="fab fa-instagram"></i>
        </a>

        <a href="https://www.youtube.com/@mohamadSalahia"
          class="education-social-btn youtube"
          target="_blank"
          title="YouTube"
          rel="noopener noreferrer">
          <i class="fab fa-youtube"></i>
        </a>

        <a href="https://www.tiktok.com/@mohamad_salahia"
          class="education-social-btn tiktok"
          target="_blank"
          title="TikTok"
          rel="noopener noreferrer">
          <i class="fab fa-tiktok"></i>
        </a>

        <a href="https://www.linkedin.com/in/mohammed-salahia/"
          class="education-social-btn linkedin"
          target="_blank"
          title="LinkedIn"
          rel="noopener noreferrer">
          <i class="fab fa-linkedin-in"></i>
        </a>

        <a href="https://github.com/MohamedSalahia"
          class="education-social-btn github"
          target="_blank"
          title="GitHub"
          rel="noopener noreferrer">
          <i class="fab fa-github"></i>
        </a>

        <a href="https://wa.me/905342813050"
          class="education-social-btn whatsapp"
          target="_blank"
          title="WhatsApp"
          rel="noopener noreferrer">
          <i class="fab fa-whatsapp"></i>
        </a>
      </div>

    </div>
  </div>

  <!-- BEGIN: Vendor JS-->
  <script src="{{ asset('admin_assets/app-assets/vendors/js/vendors.min.js') }}"></script>

  <!-- BEGIN: Theme JS-->
  <script src="{{ asset('admin_assets/app-assets/js/core/app-menu.js') }}"></script>
  <script src="{{ asset('admin_assets/app-assets/js/core/app.js') }}"></script>

  {{--custom js--}}
  <script src="{{ mix('admin_assets/app.js') }}"></script>

  <script>
    $(window).on('load', function() {
      if (feather) {
        feather.replace({
          width: 14,
          height: 14
        });
      }
    });

    // Educational Password toggle functionality
    function toggleEducationPassword() {
      const passwordInput = document.getElementById('education-password');
      const passwordIcon = document.getElementById('education-password-icon');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
      }
    }

    // Educational form enhancements
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('education-login-form');
      const submitBtn = document.getElementById('education-submit-btn');
      const btnText = submitBtn.querySelector('.btn-text');
      const btnLoading = submitBtn.querySelector('.btn-loading');

      // Enhanced input focus effects and floating labels
      const inputs = document.querySelectorAll('.education-input');

      // Function to update label state
      function updateLabelState(input) {
        const field = input.parentElement;
        if (input.value.trim() !== '') {
          field.classList.add('has-value');
        } else {
          field.classList.remove('has-value');
        }
      }

      inputs.forEach(input => {
        // Initialize state on page load (for browser auto-fill)
        updateLabelState(input);

        input.addEventListener('focus', function() {
          this.parentElement.classList.add('focused');
          updateLabelState(this);
        });

        input.addEventListener('blur', function() {
          this.parentElement.classList.remove('focused');
          updateLabelState(this);
        });

        input.addEventListener('input', function() {
          updateLabelState(this);

          // Real-time validation
          if (this.validity.valid) {
            this.parentElement.classList.remove('error');
          } else {
            this.parentElement.classList.add('error');
          }
        });

        // Handle browser auto-fill
        input.addEventListener('change', function() {
          updateLabelState(this);
        });

        // Handle auto-complete detection with delay
        setTimeout(() => {
          updateLabelState(input);
        }, 100);
      });

      // Form submission with loading state
      form.addEventListener('submit', function(e) {
        // Show loading state
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline-flex';
        submitBtn.disabled = true;

        // Add a small delay to show the loading animation
        setTimeout(() => {
          // The form will submit naturally after this timeout
        }, 500);
      });

      // Enhanced keyboard navigation
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && document.activeElement.classList.contains('education-input')) {
          const inputs = Array.from(document.querySelectorAll('.education-input'));
          const currentIndex = inputs.indexOf(document.activeElement);

          if (currentIndex < inputs.length - 1) {
            e.preventDefault();
            inputs[currentIndex + 1].focus();
          }
        }
      });

      // Smooth scroll to form if there are errors
      const errors = document.querySelector('.alert-danger');
      if (errors) {
        errors.scrollIntoView({
          behavior: 'smooth',
          block: 'center'
        });
      }
    });

    // Progressive enhancement for better UX
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', function() {
        // Could register service worker for offline functionality
      });
    }
  </script>
</body>
<!-- END: Body-->

</html>