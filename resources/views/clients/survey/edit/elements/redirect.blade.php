@include('clients.survey.edit.elements.element-header')
<div class="col-12 redirect-choice-block">
    @foreach ($question->answers->sortBy('type') as $answer)
        <div class="form-row option redirect-choice choice choice-sortable"
            id="answer_{{ $answer->id }}"
            data-answer-id="{{ $answer->id }}"
            data-option-id="{{ $loop->iteration }}">
            <div class="radio-choice-icon redirect-choice-{{ $answer->id }}" color="">
                <i class="fa fa-circle"></i>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-8 col-8 choice-input-block">
                {!! Form::textarea("answer[question_$question->id][answer_$answer->id][option_$loop->iteration]", $answer->content, [
                    'class' => 'form-control auto-resize answer-option-input redirect-option',
                    'data-autoresize',
                    'rows' => 1,
                ]) !!}
                {!! Form::hidden("media[question_$question->id][answer_$answer->id][option_$loop->iteration]", 
                    $answer->media->count() ? $answer->media->first()->url : null,
                    ['class' => 'image-answer-hidden']) !!}
            </div>
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 answer-image-btn-group">
                {{ Html::link('#', '', [
                    'class' => 'answer-image-btn fa fa-image upload-choice-image ' . $answer->media->count() ? 'invisible' : null,
                    'data-url' => route('ajax-fetch-image-answer')
                ]) }}
                {{ Html::link('#', '', ['class' => 'answer-image-btn fa fa-times remove-choice-option']) }}
            </div>
            @if ($answer->media->count()) 
                @include('clients.survey.edit.elements.image-answer', [
                    'imageURL' => $answer->media->first()->url
                ])
            @endif
        </div>
    @endforeach
    <div class="form-row other-choice">
        <div class="radio-choice-icon"><i class="fa fa-circle-thin"></i></div>
        <div class="other-choice-block">
            <span class="add-choice">@lang('lang.add_redirect_option')</span>
        </div>
    </div>
</div>
@include('clients.survey.edit.elements.element-footer')
