@include('clients.survey.edit.elements.element-header')
<div class="col-12 grid-question-block">
    <div class="list-of-row-column">
        <div class="form-row row-column-element">@lang('lang.row')</div>
        <div class="list-of-row-{{ $question->id }}">
            @foreach ($question->sub_questions as $subQuestion)
            <span class="row-column-content">
                <div class="draggable-area"></div>
                <div class="sub-question-content">
                    <label for="sub-question" class="col-1 row-index sub-question">
                        {{ $loop->iteration }}
                    </label>
                    {!! Form::text("sub-question-" . $loop->iteration, $subQuestion, [
                        'class' => "col-5 form-control sub-question-input",
                    ]) !!}
                    <div class="delete-row fa fa-times"></div>
                </div>
            </span>
            @endforeach
        </div>
        <span class="row-column-content">
            <div class="sub-question-content">
                <span class="add-more-row">@lang('lang.add_row')</span>
            </div>
        </span>
    </div>
    <div class="list-of-row-column">
        <div class="form-row row-column-element">@lang('lang.column')</div>
        <div class="list-of-column-{{ $question->id }}">
            @foreach ($question->sub_options as $subOption)
            <span class="row-column-content">
                <div class="draggable-area"></div>
                <div class="sub-question-content">
                    <span class="col-1 fa fa-circle-o column-icon" data-index="{{ $loop->iteration }}">
                    </span>
                    {!! Form::text("sub-question-option-" . $loop->iteration, $subOption, [
                        'class' => "col-5 form-control sub-question-option",
                    ]) !!}
                    <div class="delete-column fa fa-times"></div>
                </div>
            </span>
            @endforeach
        </div>
        <span class="row-column-content">
            <div class="sub-question-content">
                <span class="add-more-column">@lang('lang.add_column')</span>
            </div>
        </span>
    </div>
</div>
@include('clients.survey.edit.elements.element-footer')
