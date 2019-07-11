@extends ('clients.layout.master')

@push('styles')
    {!! Html::style(elixir(config('settings.public_template') . 'css/theme-styles.css')) !!}
    {!! Html::style(elixir(config('settings.public_template') . 'css/blocks.css')) !!}
    {!! Html::style(asset(config('settings.plugins') . 'highcharts/highcharts.css')) !!}
    {!! Html::style(elixir(config('settings.public_template') . 'css/form-builder-custom.css')) !!}
    {!! Html::style(elixir(config('settings.public_template') . 'css/result.css')) !!}
    {!! Html::style(elixir(config('settings.public_template') . 'css/preview.css')) !!}
    {!! Html::style(elixir(config('settings.public_template') . 'css/management.css')) !!}
@endpush

@section('btn-create-survey', 'show')

@section ('content')
    <div class="font-profile">
        @include('clients.profile.notice')
        <div class="main-block">
            <div class="container padding-profile background-container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="ui-block sub-block">
                            <div class="top-header">
                                <div class="top-header-thumb image-background-profile">
                                </div>
                                <div class="profile-section menu-section">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 list-profile-menu">
                                            <ul class="profile-menu">
                                                <li class="border-bottom-left">
                                                    <a href="javascript:void(0)"
                                                        class="active menu-management" id="overview-survey"
                                                        data-url="{{ route('ajax-get-overview', $survey->token_manage) }}">
                                                        @lang('survey.overview')
                                                    </a>
                                                </li>
                                               <li>
                                                    <a href="javascript:void(0)" class="menu-management" id="setting-survey"
                                                        data-url="{{ route('ajax-setting-survey', $survey->token) }}">
                                                        @lang('survey.setting')
                                                    </a>
                                                </li>
                                                <li class="border-bottom-right">
                                                    <a href="javascript:void(0)" class="menu-management" id="results-survey"
                                                        data-url="{{ route('survey.result.index', $survey->token_manage) }}">
                                                        @lang('survey.result')
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- show list survey -->
            <div class="container ui-block padding-profile div-list-survey second-block">
                <div class="ui-block-content" id="div-management-survey">
                    @include('clients.survey.management.overview')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {!! Html::script(asset(config('settings.plugins') . 'jquery-ui/jquery-ui.min.js')) !!}
    {!! Html::script(asset(config('settings.plugins') . 'popper/popper.min.js')) !!}
    {!! Html::script(asset(config('settings.plugins') . 'bootstrap/dist/js/bootstrap.min.js')) !!}
    {!! Html::script(asset(config('settings.plugins') . 'highcharts/highcharts.js')) !!}
    {!! Html::script(asset(config('settings.plugins') . 'highcharts/highcharts-3d.js')) !!}
    {!! Html::script(elixir(config('settings.public_template') . 'js/management-chart.js')) !!}
    {!! Html::script(elixir(config('settings.public_template') . 'js/result.js')) !!}
    {!! Html::script(elixir(config('settings.public_template') . 'js/management.js')) !!}
@endpush
