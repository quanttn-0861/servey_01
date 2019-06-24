<div class="item-answer">
    <div class="grid-container">
        <div class="{{ count($question->subOptions) > config('settings.number_2') ? 'grid-scroll' : '' }}">
            <div class="grid-head">
                <div class="grid-colum-head">
                    <div class="grid-first-colum none-colum"></div>
                    @foreach ($question->subOptions as $option)
                        <div class="grid-colum {{ count($question->subOptions) > config('settings.number_2') ? "multiple-option" : "" }}">{{$option}}</div>
                    @endforeach
                </div>
                @foreach ($question->subQuestions as $subQuestion)
                    <div class="grid-row">
                        <span class="grid-row-span">
                        <div class="grid-first-colum" title="{{ $subQuestion }}">{{ str_limit($subQuestion, config('settings.limit_grid')) }}</div>
                            @foreach ($question->subOptions as $option)
                                <div class="grid-colum {{ count($question->subOptions) > config('settings.number_2') ? 'multiple-option' : '' }}">
                                    <label class="container-radio-setting-survey">
                                        {!! Form::radio("$question->id-answer_" . $loop->parent->iteration, '', false, [
                                            'class' => 'radio-answer-preview',
                                        ]) !!}
                                        <span class="checkmark-radio"></span>
                                    </label>
                                </div>
                            @endforeach
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
