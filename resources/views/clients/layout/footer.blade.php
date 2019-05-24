        <!-- ******FOOTER****** -->
        <footer class="footer">
            <div class="footer-content">
                <div class="container">
                    <div class="row">
                        <div class="footer-col col-lg-4 col-md-6 col-12 links-col">
                            <div class="footer-col-inner">
                                <h3 class="sub-title about-us-title">@lang('lang.about_us')</h3>
                                <div class="list-unstyled">
                                    @lang('lang.about_us_content')
                                </div>
                            </div>
                        </div>
                        <div class="footer-col col-lg-4 col-md-6 col-12 blog-col">
                            <div class="footer-col-inner">
                                <h3 class="sub-title contact-info-title">@lang('lang.contact_info')</h3>
                                <ul class="contact-info">
                                    <li>@lang('lang.contact_us')</li>
                                    <li>
                                        <i class="fa fa-home"></i>
                                        @lang('lang.company_address')
                                    </li>
                                    <li>
                                        <i class="fa fa-phone"></i>
                                        @lang('lang.company_phone')
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope"></i>
                                        @lang('lang.email'):
                                        {{ config('settings.company.hr_email_company') }}
                                    </li>
                                </ul>
                            </div>
                        </div><!--//foooter-col-->
                        <div class="footer-col col-lg-4 col-md-12 contact-col">
                            <div class="footer-col-inner">
                                <h3 class="sub-title">@lang('lang.more_info')</h3>
                                <div class="list-unstyled">
                                    @lang('lang.more_info_content')
                                </div>
                                <div class="more-tool">
                                    <a href="{{ config('settings.company.tools_company') }}" target="_blank">
                                        <i class="fa fa-gears"></i>
                                        @lang('lang.more_tools')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-bar">
                <div class="container center">
                    <small class="copyright text-center">@lang('lang.copyright')</small>
                </div>
            </div>
        </footer>
        <!-- Main Javascript -->
        {!! Html::script(asset(config('settings.plugins') . 'jquery/jquery.min.js')) !!}
        {!! Html::script(asset(config('settings.plugins') . 'bootstrap/dist/js/bootstrap.min.js')) !!}
        {!! Html::script(asset(config('settings.plugins') . 'moment/moment-with-locales.min.js')) !!}
        {!! Html::script(asset(config('settings.plugins') . 'sweetalert/dist/sweetalert.min.js')) !!}
        {!! Html::script(elixir(config('settings.plugins') . 'languages/messages.js')) !!}
        {!! Html::script(asset(config('settings.plugins') . 'pace-progress/pace.min.js')) !!}
        {!! Html::script(asset(config('settings.plugins') . 'linkifyjs/dist/linkify.min.js')) !!}
        {!! Html::script(asset(config('settings.plugins') . 'linkifyjs/dist/linkify-jquery.min.js')) !!}
        {!! Html::script(elixir(config('settings.public_template') . 'js/main.js')) !!}
        {!! Html::script(elixir(config('settings.public_template') . 'js/datepicker/bootstrap-datepicker.min.js')) !!}
        {!! Html::script(elixir(config('settings.public_template') . 'js/auth.js')) !!}
        {!! Html::script(elixir(config('settings.public_template') . 'js/alert.js')) !!}
        {!! Html::script(elixir(config('settings.public_template') . 'js/lodash.min.js')) !!}
        @stack('scripts')
    </body>
</html>
