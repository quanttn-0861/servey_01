@if ($feedbacks->isNotEmpty())
    <table class="table table-bordered table-list-survey">
        <thead>
            <tr>
                <th width="5%" class="text-center">@lang('profile.index')</th>
                <th class="text-center">@lang('lang.name')</th>
                <th class="text-center">@lang('lang.email')</th>
                <th width="30%" class="text-center">@lang('lang.feedback_content')</th>
                <th width="15%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($feedbacks as $feedback)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                        <span data-toggle="tooltip" title="{{ $feedback->name }}" class="feedback-name" val="{{ $feedback->name }}">
                            {{ $feedback->name }}
                        </span>
                    </td>
                    <td>
                        <span data-toggle="tooltip" title="{{ $feedback->email }}" class="feedback-email" val="{{ $feedback->email }}">
                            {{ $feedback->email }}
                        </span>
                    </td>
                    <td>
                        <span class="feedback-content" val="{{ $feedback->content }}">{{ str_limit($feedback->content, 60) }}</span>
                    </td>
                    <td>
                        <a href="#" class="btn btn-info feedback-detail-btn" data-toggle="tooltip" title="@lang('lang.detail')">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <a href="#" class="btn btn-danger delete-feedback-btn" data-toggle="tooltip" title="@lang('lang.remove')">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                        {{ Form::open(['route' => ['feedbacks.destroy', $feedback->id], 'method' => 'DELETE', 'class' => 'delete-feedback-form']) }}
                        {{ Form::close() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <input type="hidden" name="url_onwer" value="{{ route('ajax-list-feedback') }}" class="url_onwer">

    {{ $feedbacks->links('clients.layout.pagination') }}
@else
    @include('clients.layout.empty_data')
@endif
