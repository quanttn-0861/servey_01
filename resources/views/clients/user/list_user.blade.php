@if ($users->isNotEmpty())
    <table class="table table-bordered table-list-survey">
        <thead>
            <tr>
                <th class="text-center">@lang('profile.index')</th>
                <th class="text-center">@lang('lang.name')</th>
                <th class="text-center">@lang('lang.email')</th>
                <th class="text-center">@lang('lang.gender')</th>
                <th class="text-center">@lang('lang.role')</th>
                <th class="text-center">@lang('lang.status')</th>
                <th width="20%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->gender_custom }}</td>
                    <td>{{ $user->level_custom }}</td>
                    <td>
                        @if ($user->status == config('users.status.active'))
                            {{ Form::button($user->status_custom, ['class' => 'btn btn-info status-user', 'id' => $user->id, 'value' => $user->status]) }}
                        @elseif ($user->status == config('users.status.block'))
                            {{ Form::button($user->status_custom, ['class' => 'btn btn-danger status-user', 'id' => $user->id, 'value' => $user->status]) }}
                        @endif
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-info user-detail-btn" data-toggle="modal" title="@lang('lang.detail')" data-target="#modal-user-detail{{$user->id}}">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('management-user.edit', $user->id) }}" class="btn btn-warning"  title="@lang('lang.edit')">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger delete-user-btn" data-toggle="tooltip" title="@lang('lang.remove')">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                        {{ Form::open(['route' => ['management-user.destroy', $user->id], 'method' => 'DELETE', 'class' => 'delete-user-form']) }}
                        {{ Form::close() }}
                    </td>
                    @include('clients.user.details')
                </tr>
            @endforeach
        </tbody>
    </table>
    <input type="hidden" name="url_onwer" value="{{ route('ajax-list-user') }}" class="url_onwer">

    {{ $users->links('clients.layout.pagination') }}
@else
    @include('clients.layout.empty_data')
@endif
