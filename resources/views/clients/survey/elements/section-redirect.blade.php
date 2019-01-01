<div class="redirect-section-block redirect-section-{{ $answerRedirectId }}">
    <span class="redirect-section-label redirect-section-label-{{ $answerRedirectId }}"
        title="{{ $answerRedirectContent }}">
        {{ $answerRedirectContent }}
    </span>
    @include('clients.survey.elements.section', [
        'sectionId' => $sectionId,
        'questionId' => $questionId,
        'answerId' => $answerId,
        'optionId' => $optionId,
        'numberOfSections' => $numberOfSections,
    ])
</div>
