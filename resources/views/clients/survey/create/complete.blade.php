@extends('clients.layout.master')
@push('styles')
    {!! Html::style(elixir(config('settings.public_template') . 'css/theme-styles.css')) !!}
    {!! Html::style(elixir(config('settings.public_template') . 'css/blocks.css')) !!}
@endpush
@section('content')
    @include('clients.profile.notice')
    <div class="background-user-profile"></div>
    <div class="main-header complete-header">
        <div class="content-bg-wrap">
            <div class="content-bg bg-events"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-sm-12 col-xs-12">
                    <div class="main-header-content">
                        <img src="{{ config('settings.create_survey_complete.congrat_img') }}" class="congrat-img">
                        <h3>@lang('lang.thank_you'), {{ $user->name }}</h3>
                        <h5>@lang('lang.create_survey_success')</h5>
                        <h6>
                            @lang('lang.send_mail_link_message') {{ $user->email }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <img class="img-bottom complete-bottom" src="{{ config('settings.create_survey_complete.header_img') }}" alt="friends">
    </div>
    <div class="container complete-content">
        <div class="row">
            <div class="col-xl-12 push-xl-12 col-lg-12 push-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="ui-block">
                    <div class="ui-block-title">
                        <h3 class="title">@lang('lang.survey_link_title')</h3>
                    </div>
                    <div class="ui-block-content">
                        <p>@lang('lang.survey_link_message')</p>
                        <p><a href="{{ $link }}" target="_blank" class="c-orange link-survey"> {{ $link }}</a></p>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-xs-2">
                                <a href="#" class="btn btn-green btn-sm full-width copy-link-survey">
                                    <i class="fa fa-clone"></i>
                                    @lang('lang.copy_link')
                                    <span class="tooltiptext">@lang('lang.copy_link')</span>
                                </a>
                            </div>
                            {{-- <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-xs-2">
                                <a href="#" class="btn btn-blue btn-sm full-width">
                                    <i class="fa fa-facebook-square"></i>
                                    @lang('lang.share')
                                </a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 push-xl-12 col-lg-12 push-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="ui-block">
                    <div class="ui-block-title">
                        <h3 class="title">@lang('lang.manage_link_title')</h3>
                    </div>
                    <div class="ui-block-content">
                        <p>@lang('lang.manage_link_message')</p>
                        <p><a href="{{ $linkManage }}" target="_blank" class="c-orange link-manage"> {{ $linkManage }}</a></p>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-xs-2">
                                <a href="#" class="btn btn-green btn-sm full-width copy-link-manage">
                                    <i class="fa fa-clone"></i>
                                    @lang('lang.copy_link')
                                    <span class="tooltiptext">@lang('lang.copy_link')</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 push-xl-12 col-lg-12 push-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="ui-block">
                    <div class="ui-block-content control-btn">
                        <div class="row col-12 col-md-8 col-lg-7">
                            <div class="col-12 col-sm-6">
                                <a href="{{ route('surveys.create') }}" class="btn btn-white btn-md full-width">
                                    @lang('lang.create_other')
                                </a>
                            </div>
                            <div class="col-12 col-sm-6">
                                <a href="{{ route('survey.survey.show-surveys') }}" class="btn btn-orange btn-md full-width">
                                    @lang('lang.my_surveys')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
