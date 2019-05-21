@include('clients.survey.edit.elements.element-header')
    <div class="col-12 linear-scale-block" data-question-id="{{ $question->id }}">
        <div class="form-row">
            <div class="col-2 min-value">
                {!! Form::hidden("min_value_hidden_$question->id", $question->setting_value->min_value) !!}
                {!! Form::select("min_value_$question->id", [], null, ['class' => "form-control min-value-$question->id"]) !!}
            </div>
            <span class="padding-10">{{ trans('lang.to') }}</span>
            <div class="col-2">
                {!! Form::hidden("max_value_hidden_$question->id", $question->setting_value->max_value) !!}
                {!! Form::select("max_value_$question->id", [], null, ['class' => "form-control max-value-$question->id"]) !!}
            </div>
        </div>
        <br>
        <div class="form-row">
            <label for="min-content-{{ $question->id }}" class="col-1 min-content-{{ $question->id }} padding-10"></label>
            {!! Form::text("min_content_$question->id", $question->setting_value->min_content, [
                'class' => "col-5 form-control min-content-$question->id",
                'placeholder' => trans('lang.label_option')
            ]) !!}
        </div>
        <div class="form-row">
            <label for="max-content-{{ $question->id }}" class="col-1 max-content-{{ $question->id }} padding-10"></label>
            {!! Form::text("max_content_$question->id", $question->setting_value->max_content, [
                'class' => "col-5 form-control max-content-$question->id",
                'placeholder' => trans('lang.label_option')
            ]) !!}
        </div>
    </div>
