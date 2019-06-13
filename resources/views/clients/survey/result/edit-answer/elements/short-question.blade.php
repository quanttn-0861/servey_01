<div class="item-answer">
    <div class="magic-box-preview short-answer-preview">
        {!! Form::textarea('', $result->content, ['class' => 'input-answer-other auto-resize answer-text short-answer-text',
            'data-autoresize', 'rows' => 1]) !!}
    </div>
</div>
<div class="notice-max-length">@lang('lang.require_length_short')</div>
