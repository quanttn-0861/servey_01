<div class="item-answer">
    <div class="group-radio-container">
        <div class="range-label-column">
            <div class="content-range-label"></div>
            <div>
                <div class="content-range-label">
                    {{ $question->setting_value->min_content ?? '' }}
                </div>
            </div>
        </div>
        <div class="list-radio-container">
            @for ($i = $question->setting_value->min_value; $i <= $question->setting_value->max_value; $i++)
                <label class="content-column">
                    <div class="item-content-column">{{ $i }}</div>
                    <div class="item-content-column-input">
                        {!! Form::radio("answer_$question->id", '', false, [
                            'class' => 'choice-answer group-radio-answer',
                        ]) !!}
                        <span class="group-radio"></span>
                    </div>
                </label>
            @endfor
        </div>
        <div class="range-label-column">
            <div class="content-range-label"></div>
            <div class="content-range-label">
                {{ $question->setting_value->max_content ?? '' }}
            </div>
        </div>
    </div>
</div>
