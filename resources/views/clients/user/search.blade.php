<div class="row">
    {!! Form::open([
        'class' => 'form-search-list-survey col-xl-12 push-xl-12 col-lg-12 push-lg-12 col-md-12 col-sm-12 col-xs-12']) !!}
        <div class="col-xl-3 push-xl-3 col-lg-3 push-lg-3 col-md-3 col-sm-3 col-xs-3">
            {!! Form::text('name', null, [
                'class' => 'form-control element-search-survey',
                'placeholder' => trans('lang.enter_name_or_email')
            ]) !!}
        </div>
        <div class="col-xl-3 push-xl-3 col-lg-3 push-lg-3 col-md-3 col-sm-3 col-xs-3 btn-search-owner">
            <a href="javascript:void(0)"
                class="btn btn-info btn-search-survey"
                data-toggle="tooltip"
                title="@lang('survey.search')"
                data-url="{{ route('ajax-list-user') }}">
                <i class="fa fa-search" aria-hidden="true"></i>
            </a>
        </div>
    {!! Form::close() !!}
</div>
