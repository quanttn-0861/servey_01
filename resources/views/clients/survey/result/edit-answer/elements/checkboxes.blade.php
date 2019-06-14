@foreach ($question->answers->sortBy('type') as $answer)
    <div class="item-answer" data-id="{{ $answer->id }}" data-type="{{ $answer->type }}">
        @php
            $idResults = $result->pluck('answer_id')->all();
            $check = in_array($answer->id, $idResults) ? true : false;
            $detailResults = $result->pluck('content', 'answer_id')->all();
        @endphp
        @if ($answer->media->count())
            <div class="img-preview-answer-survey img-checkbox-preview
                {{ $check ? 'image-active-result' : '' }}">
                {!! Html::image($answer->url_media, '',
                    ['class' => 'img-answer']) !!}
            </div>
        @endif
        @if ($answer->type == config('settings.answer_type.other_option'))
            <label class="container-checkbox-setting-survey block-hover">
                <span>@lang('lang.other')</span>
                {!! Form::checkbox('answer' . $question->id,
                    '',
                    $check,
                    ['class' => 'choice-answer checkbox-answer-preview']) !!}
                <span class="checkmark-setting-survey"></span>
            </label>
            <div class="magic-box-preview">
                {!! Form::text('', $check ? $detailResults[$answer->id] : '',
                    ['class' => 'option-other input-answer-other input-checkbox-other']) !!}
            </div>
        @else
            <label class="container-checkbox-setting-survey block-hover">
                <span>{!! nl2br(e($answer->content)) !!}</span>
                {!! Form::checkbox('answer' . $question->id,
                    '',
                    $check,
                    ['class' => 'choice-answer checkbox-answer-preview']) !!}
                <span class="checkmark-setting-survey"></span>
            </label>
        @endif
    </div>
@endforeach
