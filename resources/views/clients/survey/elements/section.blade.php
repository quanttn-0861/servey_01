<ul class="clearfix form-wrapper page-section sortable"
    id="section_{{ $sectionId }}" data-section-id="{{ $sectionId }}">
    <li class="p-0">
        <div class="form-header">
            <div class="section-badge section-option-menu">
                <span class="number-of-section">@lang('lang.section') <span class="section-index">{{ $numberOfSections + 1 }}</span> / <span class="total-section">{{ $numberOfSections }}</span></span>
                <div class="right-header-section">
                    <a href="" class="zoom-in-btn zoom-btn">
                        <span class="zoom-icon"></span>
                    </a>
                    <div class="option-menu-group">
                        <a href="#" class="fa fa-ellipsis-v option-menu"></a>
                        <ul class="option-menu-dropdown">
                            <li>
                               <span>@lang('lang.duplicate_section')</span>
                            </li>
                            <li>
                                <span>@lang('lang.move_section')</span>
                            </li>
                            <li>
                                <span>@lang('lang.delete_section')</span>
                            </li>
                            <li>
                                <span>@lang('lang.merge_with_above')</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr/>
            {!! Form::textarea("title[section_$sectionId]", '', [
                'placeholder' => trans('lang.section-title'),
                'class' => 'form-control input-area auto-resize section-header-title',
                'data-autoresize',
                'rows' => 1,
            ]) !!}
            {!! Form::textarea("description[section_$sectionId]", '', [
                'class' => 'form-control input-area auto-resize section-header-description',
                'data-autoresize',
                'placeholder' => trans('lang.description_section_placeholder'),
                'rows' => 1,
            ]) !!}
        </div>
    </li>
    @include('clients.survey.elements.multiple-choice', [
        'sectionId' => $sectionId,
        'questionId' => $questionId,
        'answerId' => $answerId,
        'optionId' => $optionId,
    ])
    <li class="end-section">
        <span class="end-section-title">@lang('lang.after_section')</span>
        <div class="end-section-dropdown">
            <div class="section-select">
                <div class="section-select-styled">
                    <span>@lang('lang.continue_next_section')</span>
                </div>
                <ul class="section-select-options">
                    @for($i = 1; $i <= $numberOfSections; $i++)
                        <li>
                            <span>@lang('lang.go_to_section', ['part' => $i])</span>
                        </li>
                    @endfor
                    <li>
                        <span>@lang('lang.submit_form')</span>
                    </li>
                </ul>
            </div>
        </div>
    </li>
</ul>
