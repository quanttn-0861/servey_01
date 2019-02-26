<div class="redirect-section-block redirect-section-{{ $answerRedirectId }}"
    data-number-redirect-section="" data-redirect-id="{{ $answerRedirectId }}">
    <span class="redirect-section-label redirect-section-label-{{ $answerRedirectId }}"></span>
    @foreach ($redirectSection as $section)
        @include('clients.survey.edit.elements.section', [
            'section' => $section,
            'typeSectionClass' => 'redirect-section',
        ])
    @endforeach
</div>
