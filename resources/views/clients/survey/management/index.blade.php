@extends ('clients.layout.master')

@push('styles')
    {!! Html::style(elixir(config('settings.public_template') . 'css/theme-styles.css')) !!}
    {!! Html::style(elixir(config('settings.public_template') . 'css/blocks.css')) !!}
    {!! Html::style(asset(config('settings.plugins') . 'highcharts/highcharts.css')) !!}
    {!! Html::style(elixir(config('settings.public_template') . 'css/form-builder-custom.css')) !!}
    {!! Html::style(elixir(config('settings.public_template') . 'css/result.css')) !!}
    {!! Html::style(elixir(config('settings.public_template') . 'css/preview.css')) !!}
    {!! Html::style(elixir(config('settings.public_template') . 'css/management.css')) !!}
    {!! Html::style(elixir(config('settings.public_template') . 'css/datepicker.css')) !!}
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
                <div class="row group-select-date" id="group-select-date-overview">
                    <div class="col-sm-2 label-choose-date">
                        <label>@lang('lang.start_date')</label>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group date datepicker">
                            <input class="form-control overview-input-date" id="chart-start-date" type="text" />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-2 label-choose-date">
                        <label>@lang('lang.end_date')</label>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group date datepicker">
                            <input class="form-control overview-input-date" id="chart-end-date" type="text" />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                    <br>
                    <div class="col-sm-2 group-result-button">
                        <a href="#" class="btn btn-info see-result-by-date" data-url="{{ route('see-result-by-date') }}" data-survey-id="{{ $survey->id }}"  title="@lang('lang.see_result')">
                            <i class="fa fa-search"></i>
                        </a>
                        <a href="#" class="btn btn-info see-overview-result" title="@lang('lang.see_overview')">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>
                </div>
                <br><br>
                <div class="row group-select-date " id="group-select-date-result">
                    <div class="col-sm-4">
                        <label>@lang('lang.start_date')</label>
                        <div class="input-group date datepicker">
                            <input class="form-control personal-input-date" id="chart-personal-start-date" type="text" />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label>@lang('lang.end_date')</label>
                        <div class="input-group date datepicker">
                            <input class="form-control personal-input-date" id="chart-personal-end-date" type="text" />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-4 group-result-button">
                        <a href="#" class="btn btn-info result-personal-by-date" data-url="{{ route('result-personal-by-date') }}" data-survey-id="{{ $survey->id }}"  title="@lang('lang.see_result')">
                            <i class="fa fa-search"></i>
                        </a>
                        <a href="#" class="btn btn-info see-overview-result" title="@lang('lang.see_overview')">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>
                </div>
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
    {!! Html::script(elixir(config('settings.public_template') . 'js/bootstrap-datepicker.js')) !!}
@endpush
