@extends('survey.profile.layout')

@section('content-profile')
    <div class="container padding-profile">
        <div class="row">
            <div class="left-profile col-xl-3 pull-xl-3 col-lg-3 pull-lg-3 col-md-12 col-sm-12 col-xs-12">
                <div class="ui-block">
                    <div class="ui-block-title">
                        <a href="{{ route('survey.profile.show', $user->id) }}"><h6 class="title title-profile">@lang('lang.personal_info')</h6></a>
                    </div>
                    @if (Auth::user() == $user)
                        <div class="ui-block-title">
                            <a href="{{ route('survey.profile.edit', $user->id) }}"><h6 class="title title-profile">@lang('lang.change_info')</h6></a>
                        </div>
                        <div class="ui-block-title">
                            <a href="{{ route('survey.profile.changepassword') }}"><h6 class="title title-profile active">@lang('lang.change_password')</h6></a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="right-profile col-xl-9 push-xl-9 col-lg-9 push-lg-9 col-md-12 col-sm-12 col-xs-12">
                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title title-top">@lang('lang.change_password')</h6>
                    </div>
                    <div class="ui-block-content">
                        {!! Form::open(['class' => 'install-form', 'route' => 'survey.profile.changepassword', 'method' => 'post']) !!}
                            <div class="form-group row">
                                {!! Form::label('oldpassword', trans('lang.old_password'), ['class' => 'col-sm-3 col-form-label-profile']) !!}
                                <div class="col-sm-7">
                                    {!! Form::password('oldpassword', ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                {!! Form::label('newpassword', trans('lang.new_password'), ['class' => 'col-sm-3 col-form-label-profile']) !!}
                                <div class="col-sm-7">
                                    {!! Form::password('newpassword', ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                {!! Form::label('retypepassword', trans('lang.re_type_password'), ['class' => 'col-sm-3 col-form-label-profile']) !!}
                                <div class="col-sm-7">
                                    {!! Form::password('retypepassword', ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="btn-submit-profile">
                                    <div class="align-btn">
                                        {!! Form::button(trans('lang.update'), ['type' => 'submit', 'class' => 'btn btn-round btn-sm btn-secondary']) !!}
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