<div class="item-answer">
    <span class="description-date-time">@lang('lang.hour') :</span>
    <div class="input-group date">
        <input type="text" class="timepicker-edit input-answer-other answer-text
            datetimepicker-input time-answer-preview"
            id="timepicker-preview{{ $question->id }}" data-toggle="datetimepicker"
            data-target="#timepicker-preview{{ $question->id }}"
            placeholder="{{ $result->content == '' ? 'hh:mm' : $result->content }}"
            data-content="{{ $result->content }}"
        />
    </div>
</div>
