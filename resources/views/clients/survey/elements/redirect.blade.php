<li class="form-line sort" id="question_{{ $questionId }}"
    data-question-id="{{ $questionId }}"
    data-question-type="config('settings.question_type.redirect')"
    data-number-answer="1">
    <div class="form-row draggable-area"></div>
    <div class="form-row answer-block">
        <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-10">
            {!! Form::textarea("title[section_$sectionId][question_$questionId]", '', [
                'class' => 'form-control input-area auto-resize question-input active',
                'data-autoresize',
                'placeholder' => trans('lang.question'),
                'rows' => 1,
            ]) !!}
            {!! Form::hidden("media[section_$sectionId][question_$questionId]", isset($imageURL) ? $imageURL : '', ['class' => 'image-question-hidden']) !!}
        </div>
        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 question-image-block">
            {{ Html::link('#', '', ['class' => 'question-image-btn fa fa-image', 'data-url' => route('ajax-fetch-image-question')]) }}
        </div>
    </div>
    <div class="form-row description-input">
        <div class="col-12">
            {!! Form::textarea("description[section_$sectionId][question_$questionId]", '', [
                'class' => 'form-control question-description-input input-area auto-resize',
                'data-autoresize',
                'placeholder' => trans('lang.description_section_placeholder'),
                'rows' => 1
            ]) !!}
        </div>
    </div>
    <div class="form-row element-content">
        <div class="col-12 multiple-choice-block">
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
    </div>
    <div class="form-row question-action-group">
        <div class="question-survey-btn">
            <a href="#" class="remove-element"><i class="fa fa-trash"></i></a>
            <p>@lang('lang.required')</p>
            <div class="question-required-checkbox">
                <label>
                    {{ Form::hidden("require[section_$sectionId][question_$questionId]",
                        config('settings.question_require.require'), [
                            'class' => 'checkbox-question-required',
                            'checked',
                            'disabled'
                        ]) }}
                    <span class="toggle active disabled"><span class="ripple"></span></span>
                </label>
            </div>
            <div class="option-menu-group">
                <a href="#" class="fa fa-ellipsis-v option-menu"></a>
                <ul class="option-menu-dropdown">
                    <li class="remove-element">
                        <i class="fa fa-trash"></i>
                        <span class="option-menu-content">@lang('lang.remove_item')</span>
                    </li>
                    <h5>@lang('lang.show')</h5>
                    <li>
                        <span class="option-menu-selected">
                            <span></span>
                        </span>
                        <span class="option-menu-content">@lang('lang.description')</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</li>
