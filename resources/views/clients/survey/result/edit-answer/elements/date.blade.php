<div class="item-answer">
    <span class="description-date-time">@lang('lang.date') :</span>
    <div class="input-group date">
        <input type="text" class="datepicker-edit input-answer-other answer-text
            datetimepicker-input date-answer-preview"
            id="datepicker-preview{{ $question->id }}" data-toggle="datetimepicker" data-dateformat="{{ $question->value_setting }}"
            data-target="#datepicker-preview{{ $question->id }}"
            placeholder="{{ $result ? ($result->content == '' ? strtolower($question->value_setting) : $result->content) : strtolower($question->value_setting) }}"
            data-content="{{ $result ? $result->content : '' }}"
        />
    </div>
</div>
