@extends ('clients.profile.layout')

@section ('content-profile')
    <div class="container padding-profile">
        <div class="row">
            <div class="left-profile col-xl-3 pull-xl-3 col-lg-3 pull-lg-3 col-md-12 col-sm-12 col-xs-12">
                <div class="ui-block">
                    <div class="ui-block-title">
                        <a href="{{ route('survey.profile.show', $user->id) }}"><h6 class="title title-profile active">@lang('profile.personal_info')</h6></a>
                    </div>
                    @if (Auth::user() == $user)
                        <div class="ui-block-title">
                            <a href="{{ route('survey.profile.edit', $user->id) }}"><h6 class="title title-profile">@lang('profile.change_info')</h6></a>
                        </div>
                        <div class="ui-block-title">
                            <a href="{{ route('survey.profile.changepassword') }}"><h6 class="title title-profile">@lang('profile.change_password')</h6></a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="right-profile col-xl-9 push-xl-9 col-lg-9 push-lg-9 col-md-12 col-sm-12 col-xs-12">
                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title title-top">@lang('profile.personal_info')</h6>
                    </div>
                    <div class="ui-block-content">
                        <ul class="widget w-personal-info">
                            <li>
                                <span class="title">@lang('profile.name')</span>
                                <span class="text">{{ ucwords($user->name) }}</span>
                            </li>
                            <li>
                                <span class="title">@lang('profile.email')</span>
                                <span class="text">{{ $user->email }}</span>
                            </li>
                            <li>
                                <span class="title">@lang('profile.birthday')</span>
                                <span class="text">{{ $user->birthday }}</span>
                            </li>
                            <li>
                                <span class="title">@lang('profile.gender')</span>
                                <span class="text">{{ $user->gender_custom }}</span>
                            </li>
                            <li>
                                <span class="title">@lang('profile.phone')</span>
                                <span class="text">{{ $user->phone }}</span>
                            </li>
                            <li>
                                <span class="title">@lang('profile.address')</span>
                                <span class="text">{{ ucwords($user->address) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! Html::script(elixir(config('settings.public_template') . 'js/survey.js')) !!}
@endpush

