<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>@lang('lang.web_title')</title>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{ Html::favicon(asset('templates/survey/images/icon/favicon.ico')) }}

        <!-- Plugins CSS -->
        {!! Html::style(asset(config('settings.plugins') . 'bootstrap/dist/css/bootstrap.min.css')) !!}
        {!! Html::style(elixir(config('settings.public_template') . 'css/preview.css')) !!}
    </head>
    <body>
        <main>
            <div class="{{ isset($content) ? 'image-header-warning' : 'image-header-complete' }}"></div>
            <div class="{{ isset($content) ? 'image-content-warning' : 'image-content-complete' }}"></div>
            <!-- Content Wrapper  -->
                <div class="wrapper-content-complete">
                    <div class="content-complete-result">
                        <div>
                            <h2 class="title-survey-preview-comlete">
                                {!! nl2br(e($title)) !!}
                            </h2>
                        </div>
                        <div>
                            <span class="{{ isset($content) ? 'description-warning' : 'description-complete' }}">
                                {{ isset($content) ? $content : trans('lang.your_answer_has_been_recorded') }}
                            </span>
                        </div>

                        @if (isset($isEditAnswer) && isset($survey) && isset($tokenResult) && $isEditAnswer)
                            <div class="edit-answer-survey">
                                <span class="back-home-description-complete">
                                    <a href="{{ route('survey.create.edit-answer', ['token' => $survey->token, 'tokenResult' => $tokenResult]) }}">
                                        @lang('lang.edit_your_answer')
                                    </a>
                                </span>
                            </div>
                        @endif
                        <div class="back-home-complete">
                            <span class="back-home-description-complete"><a href="{{ route('home') }}">&#10149; @lang('lang.home')</a></span>
                        </div>
                    </div>
                </div>
            <!-- Content Wrapper  -->
        </main>
    </body>
</html>
