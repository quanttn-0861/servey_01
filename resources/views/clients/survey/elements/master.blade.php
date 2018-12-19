<li class="form-line sort" id="question_{{ $questionId }}"
    data-question-id="{{ $questionId }}"
    data-question-type="@yield('element-type')"
    data-number-answer="1">
    <div class="form-row draggable-area"></div>
    <div class="form-row answer-block">
        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-11 col-10">
            {!! Form::textarea("title[section_$sectionId][question_$questionId]", '', [
                'class' => 'form-control input-area auto-resize question-input active',
                'data-autoresize',
                'placeholder' => trans('lang.question') . '(*)',
                'rows' => 1,
            ]) !!}
            {!! Form::hidden("media[section_$sectionId][question_$questionId]", isset($imageURL) ? $imageURL : '', ['class' => 'image-question-hidden']) !!}
        </div>
        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 question-image-block">
            {{ Html::link('#', '', ['class' => 'question-image-btn fa fa-image', 'data-url' => route('ajax-fetch-image-question')]) }}
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-8 question-dropdown-block">
            <div class="survey-select">
                <div class="survey-select-styled">
                    <span class="answer-icon multi-choice-answer-icon"></span>
                    <span class="option-menu-content">@lang('lang.multiple_choice')</span>
                </div>
                <ul class="survey-select-options">
                    <li data-type="{{ config('settings.question_type.short_answer') }}" data-url="{{ route('ajax-fetch-short-answer') }}">
                        <span class="answer-icon short-answer-icon"></span>
                        <span class="option-menu-content">@lang('lang.short_answer')</span>
                    </li>
                    <li data-type="{{ config('settings.question_type.long_answer') }}" data-url="{{ route('ajax-fetch-long-answer') }}">
                        <span class="answer-icon paragraph-answer-icon"></span>
                        <span class="option-menu-content">@lang('lang.paragraph')</span>
                    </li>
                    <hr/>
                    <li data-type="{{ config('settings.question_type.multiple_choice') }}" data-url="{{ route('ajax-fetch-multiple-choice') }}">
                        <span class="answer-icon multi-choice-answer-icon"></span>
                        <span class="option-menu-content">@lang('lang.multiple_choice')</span>
                    </li>
                    <li data-type="{{ config('settings.question_type.checkboxes') }}" data-url="{{ route('ajax-fetch-checkboxes') }}">
                        <span class="answer-icon checkboxes-answer-icon"></span>
                        <span class="option-menu-content">@lang('lang.checkboxes')</span>
                    </li>
                    <hr/>
                    <li data-type="{{ config('settings.question_type.date') }}" data-url="{{ route('ajax-fetch-date') }}">
                        <span class="answer-icon date-answer-icon"></span>
                        <span class="option-menu-content">@lang('lang.date')</span>
                    </li>
                    <li data-type="{{ config('settings.question_type.time') }}" data-url="{{ route('ajax-fetch-time') }}">
                        <span class="answer-icon time-answer-icon"></span>
                        <span class="option-menu-content">@lang('lang.time_answer')</span>
                    </li>
                </ul>
            </div>
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
        @yield('element-content')
    </div>
    <div class="form-row question-action-group">
        <div class="question-survey-btn">
            <a href="#" class="copy-element"><i class="fa fa-clone"></i></a>
            <a href="#" class="remove-element"><i class="fa fa-trash"></i></a>
            <p>@lang('lang.required')</p>
            <div class="question-required-checkbox">
                <label>
                    {{ Form::hidden("require[section_$sectionId][question_$questionId]",
                        config('settings.question_require.no_require'),
                        ['class' => 'checkbox-question-required']) }}
                    <span class="toggle"><span class="ripple"></span></span>
                </label>
            </div>
            <div class="option-menu-group">
                <a href="#" class="fa fa-ellipsis-v option-menu"></a>
                <ul class="option-menu-dropdown">
                    <li class="copy-element">
                        <i class="fa fa-clone"></i>
                        <span class="option-menu-content">@lang('lang.duplicate_item')</span>
                    </li>
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
