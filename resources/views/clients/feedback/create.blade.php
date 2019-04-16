<div class="modal fade" id="modal-feedback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content form-elegant">
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel">
                    <strong>@lang('lang.feedback')</strong>
                </h3>
                <button type="button" class="close btn-close-form" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-4">
                {{ Form::open(['route' => 'feedbacks.store', 'id' => 'form-feedback', 'method' => 'POST']) }}
                    <div class="md-form mb-5">
                        {{ Form::text('name', Auth::check() ? Auth::user()->name : '', [
                            'class' => 'form-control validate',
                            'placeholder' => trans('lang.name_placeholder'),
                            (Auth::check() ? 'readonly' : null)
                        ]) }}
                        {{ Form::label('name', trans('lang.your_name') . '(*)', ['data-error' => ' ', 'data-success' => ' ']) }}
                        <span class="help-block feedback-name-messages"></span>
                    </div>
                    <div class="md-form mb-5">
                        {{ Form::text('email', Auth::check() ? Auth::user()->email : '', [
                            'class' => 'form-control validate',
                            'placeholder' => trans('lang.email_placeholder'),
                            (Auth::check() ? 'readonly' : null)
                        ]) }}
                        {{ Form::label('email', trans('lang.your_email') . '(*)', ['data-error' => ' ', 'data-success' => ' ']) }}
                        <span class="help-block feedback-email-messages"></span>
                    </div>
                    <div class="md-form pb-3">
                        {{ Form::textarea('content', '', [
                            'class' => 'form-control validate md-textarea feedback-content',
                            'placeholder' => trans('lang.feedback_content_placeholder'),
                            'rows' => 8,
                        ]) }}
                        {{ Form::label('content', trans('lang.feedback_content') . '(*)', ['data-error' => ' ', 'data-success' => ' ']) }}
                        <span class="help-block feedback-content-messages"></span>
                    </div>
                    <div class="text-center mb-3">
                        {{ Form::button(trans('lang.send_feedback'), [
                            'type' => 'submit',
                            'class' => 'btn blue-gradient btn-block btn-rounded z-depth-1a',
                            'id' => 'btn-feedback'
                        ]) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
