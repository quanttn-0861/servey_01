<!-- .cd-main-header -->
<main class="cd-main-content">
    <!-- Content Wrapper  -->
    <div class="content-wrapper content-wrapper-management">
        <!-- /Scroll buttons -->
        <ul class="clearfix form-wrapper content-margin-top-preview ul-result content-margin-top-management section-resize">
            <li class="form-line-title-survey-result">
                <div class="form-group-title-survey">
                    <h2 class="title-survey-result" data-placement="bottom" data-toggle="tooltip"
                        title="{{ $survey->showTitleTooltip() }}">
                        {!! nl2br(e($survey->limit_title)) !!}
                    </h2>
                </div>
                <div class="form-group">
                    <span class="description-survey">{!! nl2br(e($survey->description)) !!}</span>
                </div>
                <div class="row">
                    <div class="btn-group col-md-6 col-xs-12" role="group">
                        <a href="{{ route('survey.result.index', $survey->token_manage) }}"
                            class="btn btn-secondary-result-answer"
                            id="btn-summary-result"
                            data-url="{{ route('survey.result.index', $survey->token_manage) }}">
                            @lang('result.summary')
                        </a>
                        <a href="{{ route('survey.result.detail-result', $survey->token_manage) }}"
                            class="btn btn-secondary-result-answer btn-secondary-result-answer-actived"
                            id="btn-personal-result"
                            data-url="{{ route('survey.result.detail-result', $survey->token_manage) }}">
                            @lang('result.personal')
                        </a>
                    </div>
                    @if ($countResult)
                        <div class="btn-export-excel col-md-6 col-xs-12">
                            <div class="action-view-detail-answer">
                                <a class="preview-answer-detail" href="#">❮</a>
                                <input value="{{ $pageCurrent }}" type="number" name="" class="page-answer-detail">
                                <span>/</span>
                                <span class="count-result">{{ $countResult }}</span>
                                <a class="next-answer-detail" href="#">❯</a>
                            </div>
                        </div>
                        @if ($survey->required != config('settings.survey_setting.answer_required.none'))
                            @php
                                $email = $details->first()->first()->user
                                    ? $details->first()->first()->user->email : trans('lang.incognito');
                            @endphp
                            <div class="col-md-12 col-xs-12">
                                <span class="show-email-result">@lang('lang.email'): {{ $email }}</span>
                            </div>
                        @endif
                    @endif
                </div>
            </li>
        </ul>
        <div class="content-section-preview">
            @if (!$countResult)
                <ul class="clearfix form-wrapper ul-result wrapper-section-result unset-max-with section-resize">
                    <li class="li-question-review form-line">
                        <span class="message-result">@lang('pagination.empty_data')</span>
                    </li>
                </ul>
            @else
                @php
                    $index = config('settings.number_0');
                @endphp
                @foreach ($survey->sections as $section)
                    @if (!$section->redirect_id)
                        @php
                            ++$index;
                        @endphp
                        @include ('clients.survey.result.personal_redirect_result')
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    <!-- Content Wrapper  -->
</main>
