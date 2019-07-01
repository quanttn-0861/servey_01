<div class="item-answer">
    <div class="grid-container">
        <div class="{{ count($question->sub_options) > config('settings.number_2') ? 'grid-scroll' : '' }}">
            <div class="grid-head">
                <div class="grid-colum-head">
                    <div class="grid-first-colum none-colum"></div>
                    @foreach ($question->sub_options as $option)
                        <div class="grid-colum {{ count($question->sub_options) > config('settings.number_2') ? 'multiple-option' : '' }}">{{$option}}</div>
                    @endforeach
                </div>
                @foreach ($question->sub_questions as $subQuestion)
                <div class="grid-row">
                    <span class="grid-row-span">
                    <div class="grid-first-colum" data-row-index="{{ $loop->iteration }}" title="{{ $subQuestion }}">{{ str_limit($subQuestion, config('settings.limit_grid')) }}</div>
                        @foreach ($question->sub_options as $option)
                            <div class="grid-colum {{ count($question->sub_options) > config('settings.number_2') ? 'multiple-option' : '' }}">
                                <label class="container-radio-setting-survey" data-col-index="{{ $loop->iteration }}">
                                    {!! Form::radio("$question->id-answer_" . $loop->parent->iteration, '', false, [
                                        'class' => 'choice-answer radio-answer-preview',
                                        ($result && $result->array_content[$loop->parent->iteration] != ''
                                        && $result->array_content[$loop->parent->iteration] == $loop->iteration) ? 'checked' : '',
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
