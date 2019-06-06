<div class="item-answer">
    <div class="grid-container">
        <div class="grid-scroll">
            <div class="grid-head">
                <div class="grid-colum-head">
                    <div class="grid-first-colum none-colum"></div>
                    @foreach ($question->sub_options as $option)
                        <div class="grid-colum">{{$option}}</div>
                    @endforeach
                </div>
                @foreach ($question->sub_questions as $subQuestion)
                <div class="grid-row">
                    <span class="grid-row-span">
                    <div class="grid-first-colum" data-row-index="{{ $loop->iteration }}">{{$subQuestion}}</div>
                        @foreach ($question->sub_options as $option)
                            <div class="grid-colum">
                                <label class="container-radio-setting-survey" data-col-index="{{ $loop->iteration }}">
                                    {!! Form::radio('answer_' . $loop->parent->iteration, '', false, [
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
