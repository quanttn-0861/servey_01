    </div>
    @php
        $isRedirectQuestion = $question->type == config('settings.question_type.redirect');
    @endphp
    <div class="form-row question-action-group">
        <div class="question-survey-btn">
            @if (!$isRedirectQuestion)
                <a href="#" class="copy-element"><i class="fa fa-clone"></i></a>
            @endif
            <a href="#" class="remove-element"><i class="fa fa-trash"></i></a>
            <p>@lang('lang.required')</p>
            <div class="question-required-checkbox">
                <label>
                    {{ Form::hidden("require[section_$sectionId][question_$question->id]", 
                        $question->required, 
                        ['class' => 'checkbox-question-required']) }}
                    <span class="toggle {{ $isRedirectQuestion ? 'active disabled' : null }}">
                        <span class="ripple"></span>
                    </span>
                </label>
            </div>
            <div class="option-menu-group">
                <a href="#" class="fa fa-ellipsis-v option-menu"></a>
                <ul class="option-menu-dropdown">
                    @if (!$isRedirectQuestion)
                        <li class="copy-element">
                            <i class="fa fa-clone"></i>
                            <span class="option-menu-content">@lang('lang.duplicate_item')</span>
                        </li>
                    @endif
                    <li class="remove-element">
                        <i class="fa fa-trash"></i>
                        <span class="option-menu-content">@lang('lang.remove_item')</span>
                    </li>
                    <h5>@lang('lang.show')</h5>
                    <li>
                        <span class="option-menu-selected {{ $question->description ? 'active' : '' }}">
                            <span></span>
                        </span>
                        <span class="option-menu-content">@lang('lang.description')</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</li>
