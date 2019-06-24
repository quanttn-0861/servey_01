<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content form-elegant">
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel">
                    <strong>@lang('lang.login')</strong>
                </h3>
                <button type="button" class="close btn-close-form" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-4">
                {{ Form::open(['route' => 'login', 'id' => 'formLogin', 'method' => 'POST']) }}
                    <div class="md-form mb-5">
                        {{ Form::email('email', old('email'), [
                            'class' => 'form-control validate',
                            'placeholder' => trans('lang.email_placeholder'),
                            'id' => 'email'
                        ]) }}
                        {{ Form::label('email', trans('lang.email') . '(*)', ['data-error' => ' ', 'data-success' => ' ', ]) }}
                        <span class="help-block login-messages"></span>
                    </div>
                    <div class="md-form">
                        {{ Form::password('password', [
                            'class' => 'form-control validate',
                            'placeholder' => trans('lang.password_placeholder'),
                            'id' => 'password'
                        ]) }}
                        {{ Form::label('password', trans('lang.password') . '(*)', ['data-error' => ' ', 'data-success' => ' ', ]) }}
                        <span class="help-block login-messages-password"></span>
                        <p class="font-small blue-text d-flex justify-content-end">
                            <a data-toggle="modal" data-dismiss="modal" data-target="#modalForgotPassword" href="#" class="blue-text ml-1">
                                @lang('lang.forgot') @lang('lang.password')&#63;
                            </a>
                        </p>
                    </div>
                    <div class="text-center mb-3">
                        {{ Form::button(trans('lang.login'), ['type' => 'submit', 'class' => 'btn blue-gradient btn-block btn-rounded z-depth-1a', 'id' => 'btn-signin']) }}
                    </div>
                {{ Form::close() }}
                <p class="font-small dark-grey-text text-right d-flex justify-content-center mb-3">
                    @lang('lang.or_sign_in_with')
                </p>
                {{-- <div class="row my-3 d-flex justify-content-center">
                    <a href="{{ route('socialRedirect', [config('settings.facebook')]) }}" class="btn btn-blue mr-md-3 z-depth-1a btn-social" id="btn-facebook">
                    </a>
                    <a href="{{ route('socialRedirect', [config('settings.twitter')]) }}" class="btn btn-white mr-md-3 z-depth-1a btn-social" id="btn-twitter">
                    </a>
                    <a href="{{ route('socialRedirect', config('settings.framgia')) }}" class="btn btn-orange  mr-md-3 z-depth-1a btn-social" id="bt-login-wsm">
                    </a>
                    <a href="{{ route('socialRedirect', [config('settings.google')]) }}" class="btn btn-red z-depth-1a btn-social" id="btn-google">
                    </a>
                </div> --}}
                <div class="text-center mb-3">
                    <a href="{{ route('socialRedirect', config('settings.framgia')) }}" class="btn btn-orange btn-block btn-rounded z-depth-1a" id="bt-login-wsm">
                        @lang('lang.sign_in_wsm')
                    </a>
                </div>
            </div>
            <div class="modal-footer mx-5 pt-3 mb-1">
                <p class="font-small grey-text d-flex justify-content-end">
                    @lang('lang.not_a_member')
                    <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#modalRegister" class="blue-text ml-1">
                        @lang('lang.register')
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
