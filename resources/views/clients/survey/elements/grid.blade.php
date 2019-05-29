@extends('clients.survey.elements.master')
@section('element-type', config('settings.question_type.grid'))
@section('element-content')
    <div class="col-12 grid-question-block">
        <div class="list-of-row-column">
            <div class="form-row row-column-element">@lang('lang.row')</div>
            <div class="list-of-row">
                <span class="row-column-content">
                    <div class="draggable-area"></div>
                    <div class="sub-question-content">
                        <label for="sub-question" class="col-1 row-index sub-question">
                            {{ config('settings.number_1') }}
                        </label>
                        {!! Form::text("sub-question", trans('lang.row') . " " . config('settings.number_1'), [
                            'class' => "col-5 form-control sub-question-input",
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
            <div class="list-of-column">
                <span class="row-column-content">
                    <div class="draggable-area"></div>
                    <div class="sub-question-content">
                        <span class="col-1 fa fa-circle-o column-icon" data-index="{{ config('settings.number_1') }}">
                        </span>
                        {!! Form::text("sub-question-option", trans('lang.column') . " " . config('settings.number_1'), [
                            'class' => "col-5 form-control sub-question-option",
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
