@if ($surveys->isNotEmpty())
    <table class="table table-bordered table-list-survey">
        <thead>
            <tr>
                <th class="text-center">@lang('profile.index')</th>
                <th width="25%" class="text-center">@lang('profile.name_survey')</th>
                <th class="text-center">@lang('profile.status')</th>
                <th class="text-center">@lang('survey.inviting')</th>
                <th class="text-center">@lang('survey.remaining_time')</th>
                <th width="16%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surveys as $survey)
                <tr>
                    <td class="text-center">{{ $surveys->currentPage() == 1 ? $loop->iteration : $loop->iteration + $surveys->perPage() * ($surveys->currentPage() - 1) }}</td>
                    <td>
                        @if ($survey->status == config('settings.survey.status.open'))
                            <a href="{{ route('survey.create.do-survey', $survey->token) }}" target="_blank" data-toggle="tooltip" title="{{ $survey->title }}">{{ $survey->trim_title }}</a>
                        @else
                            <a href="javascript:void(0)"  data-toggle="tooltip" title="{{ $survey->title }}" class="survey-close">{{ $survey->trim_title }}</a>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-info badge-list-survey">{{ $survey->settings->first()->value == config('settings.survey_setting.privacy.public') ? trans('profile.public') :  trans('profile.private') }}</span>
                        <span class="badge badge-secondary badge-list-survey">{{ $survey->status_custom }}</span>
                    </td>
                    <td>
                        @php
                            $invites = $survey->getInvites();
                        @endphp

                        <div class="progress process-bar-survey"
                            data-toggle="modal"
                            data-token-manage="{{ $survey->token_manage }}"
                            data-url="{{ route('survey.status-invite') }}"
                            data-target="#pupup-invite-survey"
                            data-incognito-answer="{{ $survey->getNumberIncognitoAnswer() }}">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" aria-valuenow="{{ $invites }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $invites }}%">{{ $survey->getNumberAnswer() }}/{{ $survey->getNumberInvite() }}</div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-info badge-list-survey">{{ $survey->remaining_time ? $survey->remaining_time : '' }}</span>
                    </td>
                    <td>
                        <a href="{{ route('survey.management', $survey->token_manage) }}" class="btn btn-info" data-toggle="tooltip" title="@lang('lang.setting')">
                            <i class="fa fa-cog" aria-hidden="true"></i>
                        </a>
                        @can('delete', $survey)
                            <a href="javascript:void(0)" class="btn btn-danger" id="delete-survey"
                                data-toggle="tooltip" title="@lang('survey.delete')"
                                data-url="{{ route('ajax-survey-delete', $survey->token_manage) }}">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <input type="hidden" name="url_onwer" value="{{ route('ajax-list-survey', config('settings.survey.members.owner')) }}" class="url_onwer">

    {{ $surveys->links('clients.layout.pagination') }}
@else
    @include('clients.layout.empty_data')
@endif
@include('clients.profile.survey.inviting_status')
