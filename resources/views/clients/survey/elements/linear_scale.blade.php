@extends('clients.survey.elements.master')
@section('element-type', config('settings.question_type.linear_scale'))
@section('element-content')
    <div class="col-12 linear-scale-block">
        <div class="form-row">
            <div class="col-2 min-value">
                {!! Form::select("min_value_$questionId", [], null, ['class' => "form-control min-value-$questionId"]) !!}
            </div>
            <span class="padding-10">{{ trans('lang.to') }}</span>
            <div class="col-2 max-value">
                {!! Form::select("max_value_$questionId", [], null, ['class' => "form-control max-value-$questionId"]) !!}
            </div>
        </div>
        <br>
        <div class="form-row">
            <label for="min-content-{{ $questionId }}" class="col-1 min-content-{{ $questionId }} padding-10"></label>
            {!! Form::text("min_content_$questionId", null, [
                'class' => "col-5 form-control min-content-$questionId",
                'placeholder' => trans('lang.label_option')
            ]) !!}
        </div>
        <div class="form-row">
            <label for="max-content-{{ $questionId }}" class="col-1 max-content-{{ $questionId }} padding-10"></label>
            {!! Form::text("max_content_$questionId", null, [
                'class' => "col-5 form-control max-content-$questionId",
                'placeholder' => trans('lang.label_option')
            ]) !!}
        </div>
    </div>
@endsection
