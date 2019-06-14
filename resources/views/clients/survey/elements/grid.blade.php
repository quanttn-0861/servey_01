@extends('clients.survey.elements.master')
@section('element-type', config('settings.question_type.grid'))
@section('element-content')
    <div class="col-12 grid-question-block">
        <div class="list-of-row-column">
            <div class="form-row row-column-element">@lang('lang.row')</div>
            <div class="list-of-row-{{ $questionId }}">
                <span class="row-column-content">
                    <div class="sub-question-content">
                        <label for="sub-question" class="col-1 row-index sub-question">
                            {{ config('settings.number_1') }}
                        </label>
                        {!! Form::text("sub-question-" . config('settings.number_1'), trans('lang.row') . " " . config('settings.number_1'), [
                            'class' => "col-5 form-control sub-question-input",
                            'row-question' => 'row-question-index-' . config('settings.number_1'),
                        ]) !!}
                        <div class="delete-row fa fa-times"></div>
                    </div>
                </span>
            </div>
            <span class="row-column-content">
                <div class="sub-question-content">
                    <span class="add-more-row">@lang('lang.add_row')</span>
                </div>
            </span>
        </div>
        <div class="list-of-row-column">
            <div class="form-row row-column-element">@lang('lang.column')</div>
            <div class="list-of-column-{{ $questionId }}">
                <span class="row-column-content">
                    <div class="sub-question-content">
                        <span class="col-1 fa fa-circle-o column-icon" data-index="{{ config('settings.number_1') }}">
                        </span>
                        {!! Form::text("sub-question-option-" . config('settings.number_1'), trans('lang.column') . " " . config('settings.number_1'), [
                            'class' => "col-5 form-control sub-question-option",
                            'col-value' => 'col-value-index-' . config('settings.number_1'),
                        ]) !!}
                        <div class="delete-column fa fa-times"></div>
                    </div>
                </span>
            </div>
            <span class="row-column-content">
                <div class="sub-question-content">
                    <span class="add-more-column">@lang('lang.add_column')</span>
                </div>
            </span>
        </div>
    </div>
@endsection
