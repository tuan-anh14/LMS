<footer class=" default-padding-top text-dark">
    <div class="container">
        <div class="row">
            <div class="f-items">
                <div class="col-md-4 item">
                    <div class="f-item">
                        <img src="{{ Storage::url('uploads/' . setting('logo')) }}" alt="Logo" style="width: 100px !important;">
                        {{--<img class="footer-logo" src="{{asset('images/footer_logo.jpg')}}" alt="Logo">--}}
                        <p>
                            {{setting('description')}}
                        </p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 item">
                    <div class="f-item link">
                        <h4>@lang('site.links')</h4>
                        <ul>
                            <li>
                                <a href="{{route('/')}}">الرئيسية</a>
                            </li>
                            <li>
                                <a href="{{route('courses')}}">الدورات</a>
                            </li>
                            <li>
                                <a href="{{route('contact-us')}}">تواصل معنا</a>
                            </li>
                            <li>
                                <a href="{{route('about-us')}}">من نحن</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 item">
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
                        <p>@lang('site.developer_by') <a href="https://webseity.com">@lang('site.webseity')</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Bottom -->
</footer>
