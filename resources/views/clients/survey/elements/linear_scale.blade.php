@extends('clients.survey.elements.master')
@section('element-type', config('settings.question_type.linear_scale'))
@section('element-content')
    <div class="col-12 linear-scale-block">
        <div class="form-row">
            <div class="col-2 min-value">
                {!! Form::select('min_value', [], null, ['class' => 'form-control', 'id' => 'min-value']) !!}
            </div>
            <span class="padding-10">{{ trans('lang.to') }}</span>
            <div class="col-2">
                {!! Form::select('max_value', [], null, ['class' => 'form-control', 'id' => 'max-value']) !!}
            </div>
        </div>
        <br>
        <div class="form-row">
            <label for="min-content" class="col-1 min-content padding-10">0</label>
            {!! Form::text('min_content', null, ['class' => 'col-5 form-control', 'placeholder' => trans('lang.label_option')]) !!}
        </div>
        <div class="form-row">
            <label for="max-content" class="col-1 max-content padding-10">5</label>
            {!! Form::text('max_content', null, ['class' => 'col-5 form-control', 'placeholder' => trans('lang.label_option')]) !!}
        </div>
    </div>
@endsection
