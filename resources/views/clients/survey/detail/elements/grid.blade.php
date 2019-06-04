<div class="item-answer">
    <div class="grid-container">
        <div class="content-col">
            <div class="content-data-header"></div>
            @foreach ($question->sub_questions as $subQuestion)
                <div class="content-data">
                    {{ $subQuestion }}
                </div>
            @endforeach
        </div>
        <div class="option-col">
            <div class="option-value-header">
                @foreach ($question->sub_options as $option)
                    <div class="option-data">
                        {{ $option }}
                    </div>
                @endforeach
            </div>
            @foreach ($question->sub_questions as $subQuestion)
                <div class="option-value">
                    @foreach ($question->subOptions as $option)
                        <div class="option-data">
                            <div class="cell-data">
                                <label class="choice-option">
                                    <div class="choice-option-answer">
                                        {!! Form::radio('answer_' . $loop->parent->iteration, null, false, [
                                            'class' => 'group-radio-answer',
                                        ]) !!}
                                        <span class="grid-radio"></span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
