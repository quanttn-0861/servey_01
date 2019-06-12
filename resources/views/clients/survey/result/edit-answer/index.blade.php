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
        {!! Html::style(asset(config('settings.plugins') . 'font-awesome/css/font-awesome.min.css')) !!}
        <!-- Theme CSS -->
        @if (isset($requiredLogin))
            {!! Html::style(asset(config('settings.plugins') . 'ionicons/css/ionicons.min.css')) !!}
            {!! Html::style(elixir(config('settings.public_template') . 'css/home.css')) !!}
            {!! Html::style(elixir(config('settings.public_template') . 'css/home-effect.css')) !!}
            {!! Html::style(elixir(config('settings.public_template') . 'css/modal-auth.min.css')) !!}
        @endif

        {!! Html::style(elixir(config('settings.public_template') . 'css/style.css')) !!}

        @if (!isset($requiredLogin))
            {!! Html::style(asset(config('settings.plugins') . 'tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css')) !!}
            {!! Html::style(elixir(config('settings.public_template') . 'css/form-builder-custom.css')) !!}
            {!! Html::style(elixir(config('settings.public_template') . 'css/preview.css')) !!}
        @endif
    </head>
    <body>
        <div class="background-user-profile"></div>
        @if (!isset($requiredLogin))
            <div class="page-doing-survey">
                @include('clients.survey.detail.detail_survey')
            </div>
        @endif

        @if (!Auth::guard()->check())
            {{ Html::link('#', '', [
                'id' => 'login',
                'data-toggle' => 'modal',
                'data-target' => '#modalLogin',
                'data-required-login' => isset($requiredLogin) ? $requiredLogin : '',
                'data-login-wsm' => route('socialRedirect', config('settings.framgia')),
            ]) }}
            @include('clients.user.auth.register')
            @include('clients.user.auth.login')
        @endif
    </body>
    
    @if (isset($requiredLogin))
        {!! Html::script(asset(config('settings.plugins') . 'jquery/jquery.min.js')) !!}
        {!! Html::script(asset(config('settings.plugins') . 'bootstrap/dist/js/bootstrap.min.js')) !!}
        {!! Html::script(asset(config('settings.plugins') . 'sweetalert/dist/sweetalert.min.js')) !!}
        {!! Html::script(elixir(config('settings.plugins') . 'languages/messages.js')) !!}
        {!! Html::script(elixir(config('settings.public_template') . 'js/auth.js')) !!}
        {!! Html::script(elixir(config('settings.public_template') . 'js/alert.js')) !!}
        {!! Html::script(elixir(config('settings.public_template') . 'js/required-login.js')) !!}
        </script>
    @endif
</html>
