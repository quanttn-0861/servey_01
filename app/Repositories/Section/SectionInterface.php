<?php

namespace App\Repositories\Section;

interface SectionInterface
{
    public function deleteSections($ids);

    public function closeFromSurvey($survey);

    public function openFromSurvey($survey);

    public function deleteFromSurvey($survey);

    public function cloneSection($section, $newSurvey);

    public function getSectionFromRedirectId($redirectId);

    public function checkIfExistRedirectQuestion($section);

    public function updateRedirectSections($newSurvey, $redirectIds);
}
