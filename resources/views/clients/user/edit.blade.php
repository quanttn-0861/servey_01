@extends('clients.profile.layout')

@section('content-profile')
    <div class="container padding-profile">
        <div class="row">
            <div class="left-profile col-xl-2 pull-xl-2 col-lg-2 pull-lg-2 col-md-9 col-sm-9 col-xs-12">
                <div class="ui-block"></div>
            </div>
            <div class="right-profile col-xl-9 push-xl-9 col-lg-9 push-lg-9 col-md-12 col-sm-12 col-xs-12">
                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title title-top">@lang('profile.personal_info')</h6>
                    </div>
                    <div class="ui-block-content">
                        {!! Form::open(['route' => ['management-user.update', $user->id],
                            'class' => 'install-form', 'files' => true,
                            'method' => 'put', 'id' => 'form-update-profile']) !!}
                            <h6>&#9758; @lang('profile.important_settings')</h6>
                            <div class="form-group row">
                                {!! Form::label('name', trans('profile.name'), ['class' => 'col-sm-3 col-form-label-profile']) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('name', $user->name, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                {!! Form::label('email', trans('lang.email'), ['class' => 'col-sm-3 col-form-label-profile', 'required']) !!}
                                <div class="col-sm-7">
                                    {!! Form::email('email', $user->email, ['class' => 'form-control', 'disabled']) !!}
                                </div>
                            </div>
                            <hr>
                            <h6>&#9758; @lang('profile.general_settings')</h6>
                            <div class="form-group row">
                                {!! Form::label('birthday', trans('profile.birthday'), ['class' => 'col-sm-3 col-form-label-profile']) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('birthday', $user->birthday, ['class' => 'calendar datepicker form-control', 'id' => Session::get('locale')]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                {!! Form::label('gender', trans('profile.gender'), ['class' => 'col-sm-3 col-form-label-profile']) !!}
                                <div class="col-sm-7">
                                    <label class="container-radio">
                                        {{ Form::radio('gender', config('users.gender.male'), '',
                                            ['class' => 'form-group checkbox-gender', 'id' => '1',
                                            ($user->gender == config('users.gender.male')) ? 'checked' : null]) }}
                                        @lang('profile.male')
                                        <span class="radiobtn"></span>
                                    </label>
                                    <label class="container-radio">
                                        {{ Form::radio('gender', config('users.gender.female'), '',
                                            ['class' => 'form-group checkbox-gender', 'id' => '2',
                                            ($user->gender == config('users.gender.female')) ? 'checked' : null]) }}
                                        @lang('profile.female')
                                        <span class="radiobtn"></span>
                                    </label>
                                    <label class="container-radio">
                                        {{ Form::radio('gender', config('users.gender.other_gender'), '',
                                            ['class' => 'form-group checkbox-gender', 'id' => '3',
                                            ($user->gender == config('users.gender.other_gender')) ? 'checked' : null]) }}
                                        @lang('profile.other')
                                        <span class="radiobtn"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                {!! Form::label('phone', trans('profile.phone'), ['class' => 'col-sm-3 col-form-label-profile']) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('phone', $user->phone, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                {!! Form::label('address', trans('profile.address'), ['class' => 'col-sm-3 col-form-label-profile']) !!}
                                <div class="col-sm-7">
                                    {!! Form::text('address', $user->address, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="btn-submit-profile">
                                    <div class="align-btn">
                                        {!! Form::button(trans('profile.update'), ['type' => 'submit', 'class' => 'btn btn-round btn-sm btn-secondary']) !!}
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
