@extends('clients.layout.master')

@push('styles')
    {!! Html::style(asset(config('settings.public_template') . 'css/vendor.css')) !!}
    {!! Html::style(asset(config('settings.public_template') . 'css/home-effect.css')) !!}
@endpush

@section('header-change', 'header-change')

@section('content')
    @if (Session::has('check_show_login'))
        {{ Html::link('#', '', [
            'class' => 'btn-show-pupup-login',
        ]) }}
    @endif
    @if (Session::has('confirmation-failed'))
        {!! Form::hidden('confirmation-failed', Session::get('confirmation-failed')) !!}
    @endif
    <main class="site-main">
        <div id="home" class="section block-primary align-c">
            <div id="siteBg" class="site-bg">
                <div class="site-bg-img"></div>
                <div class="site-bg-video"></div>
                <div class="site-bg-overlay"></div>
                <div class="site-bg-animation layer" data-depth="0.30"></div>
                <canvas class="site-bg-canvas layer" data-depth="0.30"></canvas>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-inner">
                            <div class="section-heading">
                                <h3 class="color-secondary survey_title_slider">@lang('lang.survey_title_slider')</h3>
                                <h1 class="survey-logo-slider">
                                    {!! config('settings.logo_content') !!}
                                </h1>
                                <p class="survey-description-slider">@lang('lang.survey_description_slider')</p>
                            </div>
                            <div class="section-content">
                                <div class="row" id="countdown_dashboard">
                                    <div class="col-xl-4 col-md-4 col-sm-4 col-6 dash days_dash">
                                        <div class="counter digit" data-count="{{ $data['users'] }}">
                                            {{ config('settings.counter_default_value') }}
                                        </div>
                                        <span class="dash_title">@lang('lang.users')</span>
                                    </div>

                                    <div class="col-xl-4 col-md-4 col-sm-4 col-6 dash">
                                        <div class="counter digit" data-count="{{ $data['surveys'] }}">
                                            {{ config('settings.counter_default_value') }}
                                        </div>
                                        <span class="dash_title">@lang('lang.surveys')</span>
                                    </div>
                                    
                                    <div class="col-xl-4 col-md-4 col-sm-4 col-6 dash">
                                        <div class="counter digit" data-count="{{ $data['feedbacks'] }}">
                                            {{ config('settings.counter_default_value') }}
                                        </div>
                                        <span class="dash_title">@lang('lang.feedbacks')</span>
                                    </div>
                                </div>

                                <a class="btn btn-primary m-a-5 start-btn" href="{{ route('surveys.create') }}"><i class="fa fa-send-o"></i> @lang('lang.get_started')</a>

                                @if (!Auth::guard()->check())
                                    <p class="text-require-login">@lang('auth.requrie_login')</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section block-default align-c-xs-max about-1">
           @include('clients.profile.notice')
            <div class="container">
                <div class="row row-table">
                    <div class="col-md-6">
                        <div class="col-inner">
                            <div class="section-heading align-c-xs-max">
                                <h2 class="feature-title-home">@lang('lang.feature_1_title')</h2>
                                <div class="divider"></div>
                            </div>
                            <div class="section-content">
                                <p>@lang('lang.feature_1_content')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 p-l-45-sm-min p-l-75-md-min">
                        <div class="col-inner clearfix">
                            {{ Html::image(config('settings.feature_icon.icon_1'), 'about-1', [
                                'class' => 'img-responsive float-r-sm-min m-x-auto-xs-max about-img',
                                'data-sr' => 'right'
                            ]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section block-light align-c-xs-max about-2">
            <div class="container">
                <div class="row row-table">
                    <div class="col-md-6 p-r-45-sm-min p-r-75-md-min">
                        <div class="col-inner clearfix">
                            {{ Html::image(config('settings.feature_icon.icon_2'), 'about-1', [
                                'class' => 'img-responsive float-l-sm-min m-x-auto-xs-max about-img about-img-2',
                                'data-sr' => 'left'
                            ]) }}
                        </div>
                      </div>
                      <div class="col-md-6 p-l-75-md-min">
                        <div class="col-inner">
                            <div class="section-heading align-c-xs-max">
                                <h2 class="feature-title-home">@lang('lang.feature_2_title')</h2>
                                <div class="divider"></div>
                            </div>
                            <div class="section-content">
                                <p>@lang('lang.feature_2_content')</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section block-default align-c-xs-max about-3">
            <div class="container">
                <div class="row row-table">
                    <div class="col-md-6">
                        <div class="col-inner">
                            <div class="section-heading align-c-xs-max">
                                <h2 class="feature-title-home">@lang('lang.feature_3_title')</h2>
                                <div class="divider"></div>
                            </div>
                            <div class="section-content">
                                <p>@lang('lang.feature_3_content')</p>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6 p-l-45-sm-min p-l-75-md-min">
                        <div class="col-inner clearfix">
                            {{ Html::image(config('settings.feature_icon.icon_3'), 'about-1', [
                                'class' => 'img-responsive float-r-sm-min m-x-auto-xs-max about-img about-img-3',
                                'data-sr' => 'right'
                            ]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    {!! Html::script(elixir(config('settings.public_template') . 'js/plugin.js')) !!}
    {!! Html::script(elixir(config('settings.public_template') . 'js/home-effect.js')) !!}
@endpush
