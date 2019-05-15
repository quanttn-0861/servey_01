<div class="item-answer">
    <div class="group-radio-container">
        <div class="range-label-column">
            <div class="content-range-label"></div>
            <div>
                <div class="content-range-label">
                    {{ $question->min_content ?? '' }}
                </div>
            </div>
        </div>
        <div class="list-radio-container">
            @for ($i = $question->min_value; $i <= $question->max_value; $i++)
                <label class="content-column">
                    <div class="item-content-column">{{ $i }}</div>
                    <div class="item-content-column-input">
                        {!! Form::radio('answer', '', false, [
                            'class' => 'radio-answer-preview',
                        ]) !!}
                        <span class="group-radio"></span>
                    </div>
                </label>
            @endfor
        </div>
        <div class="range-label-column">
            <div class="content-range-label"></div>
            <div class="content-range-label">
                {{ $question->max_content ?? '' }}
            </div>
        </div>
    </div>
</div>
