@extends('clients.profile.layout')

@section('content-profile')
    @include('clients.profile.notice')
    <div class="container ui-block padding-profile div-list-survey">
        <div class="ui-block-content">
            @include('clients.user.search')
            <div class="table-responsive" id="show-list-surveys">
                @include('clients.user.list_user')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! Html::script(elixir(config('settings.public_template') . 'js/survey.js')) !!}
@endpush
