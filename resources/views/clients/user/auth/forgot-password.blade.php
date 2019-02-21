<div class="modal fade" id="modalForgotPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content form-elegant">
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel">
                    <strong>@lang('lang.reset_password')</strong>
                </h3>
                <button type="button" class="close btn-close-form" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-4">
                {{ Form::open(['route' => 'send-mail-reset-password', 'method' => 'POST', 'id' => 'formResetPassword']) }}
                    <div class="md-form mb-5">
                        {{ Form::email('email', old('email'), [
                            'class' => 'form-control validate reset-password-email',
                            'placeholder' => trans('lang.email_placeholder'),
                        ]) }}
                        <label for="elegantFormModalInput1" >@lang('lang.email')</label>
                       <div class="reset-password-process">
                            <div class="alert alert-danger send-mail-fail hidden">
                                <span class="help-block email-reset-messages"></span>
                            </div>
                            <span class="help-block spinner hidden">
                                <i class="fa fa-spinner fa-spin"></i>
                            </span>
                       </div>
                       <div class="notification-success">
                           <div class="alert alert-success send-mail-success hidden"></div>
                       </div>
                    </div>
                    <div class="text-center mb-3">
                        {{ Form::button(trans('lang.reset_password'), [
                            'type' => 'submit',
                            'class' => 'btn blue-gradient btn-block btn-rounded z-depth-1a',
                        ]) }}
                    </div>
                {{ Form::close() }}
            </div>
            <div class="modal-footer mx-5 pt-3 mb-1">
                <p class="font-small grey-text d-flex justify-content-end">@lang('lang.not_a_member')
                    <a href="#" data-toggle="modal" data-dismiss="modal" data-target="#modalRegister" class="blue-text ml-1">
                        @lang('lang.register')
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
