<footer class=" default-padding-top text-dark">
    <div class="container">
        <div class="row">
            <div class="f-items">
                <div class="col-md-4 item">
                    <div class="f-item">
                        <img class="footer-logo" src="{{asset('images/footer_logo.jpg')}}" alt="Logo">
                        <!-- <img src="{{ asset('storage/uploads/logo.png') }}" alt="Logo" style="width: 100px !important;"> -->
                        <p></p>
                            {{setting('description')}}
                        </p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 item">
                    <div class="f-item link">
                        <h4>@lang('site.links')</h4>
                        <ul>
                            <li>
                                <a href="{{route('/')}}">Trang chủ</a>
                            </li>
                            <li>
                                <a href="{{route('courses')}}">Khóa học</a>
                            </li>
                            <li>
                                <a href="{{route('contact-us')}}">Liên hệ</a>
                            </li>
                            <li>
                                <a href="{{route('about-us')}}">Về chúng tôi</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 item"></div>
                    <div class="f-item link">
                        <h4>@lang('site.courses')</h4>
                        <ul>
                            @foreach($courses as $course)
                                <li>
                                    <a href="javascript:;">{{$course->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 item">
                    <div class="f-item address">
                        <h4>@lang('site.contact_us')</h4>
                        <ul>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <p>@lang('site.email') <span><a
                                            href="mailto:{{setting('email')}}">{{setting('email')}}</a></span>
                                </p>
                            </li>
                            <li>
                                <i class="fas fa-map"></i>
                                <p>@lang('site.phone') <span>{{setting('mobile')}}</span></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <p>@lang('site.copyright') <a
                                href="{{route('/')}}">@lang('site.for_mirage')</a> @lang('site.symbol') {{date('Y')}}
                        </p>
                    </div>
                    <div class="col-md-6 text-right link">
                        <!-- Developer info removed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Bottom -->
</footer>
