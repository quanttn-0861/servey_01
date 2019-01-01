@extends('clients.survey.elements.master')
@section('element-type', config('settings.question_type.redirect'))
@section('element-content')
    <div class="col-12 redirect-choice-block">
        @foreach ($answerIds as $answerId)
            <div class="form-row option redirect-choice choice choice-sortable"
                id="answer_{{ $answerId }}"
                data-answer-id="{{ $answerId }}"
                data-option-id="{{ $loop->iteration }}">
                <div class="radio-choice-icon redirect-choice-{{ $answerId }}" color="">
                    <i class="fa fa-circle"></i>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-8 col-8 choice-input-block">
                    {!! Form::textarea("answer[question_$questionId][answer_$answerId][option_$loop->iteration]", trans('lang.redirect_option_content', ['index' => $loop->iteration]), [
                        'class' => 'form-control auto-resize answer-option-input redirect-option',
                        'data-autoresize',
                        'rows' => 1,
                    ]) !!}
                    {!! Form::hidden("media[question_$questionId][answer_$answerId][option_$loop->iteration]", null, ['class' => 'image-answer-hidden']) !!}
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 answer-image-btn-group">
                    {{ Html::link('#', '', ['class' => 'answer-image-btn fa fa-image upload-choice-image', 'data-url' => route('ajax-fetch-image-answer')]) }}
                    {{ Html::link('#', '', ['class' => 'answer-image-btn fa fa-times remove-choice-option hidden']) }}
                </div>
            </div>
        @endforeach
        <div class="form-row other-choice">
            <div class="radio-choice-icon"><i class="fa fa-circle-thin"></i></div>
            <div class="other-choice-block">
                <span class="add-choice">@lang('lang.add_redirect_option')</span>
            </div>
        </div>
    </div>
@endsection
