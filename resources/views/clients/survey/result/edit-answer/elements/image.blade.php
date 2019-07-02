<h4 class="title-question">{{ $question->title }}</h4>
<div class="img-preview-question-survey">
    {!! Html::image($question->url_media, '', ['title' => $question->description]) !!}
</div>
