<?php

namespace App\Traits;
use Auth, Session;

trait DoSurvey
{
    public function getFirstSectionSurvey($survey)
    {
        $sectionIds = $survey->sections->sortBy('order')->pluck('id')->all();

        if ($survey->sections->where('update', config('settings.survey.section_update.updated'))->count() && Auth::user()) {
            $lastResults = $survey->results->where('user_id', Auth::user()->id)->groupBy('token')->last();

            if ($lastResults) {
                $redirectIds = $survey->sections->where('redirect_id', '!=', 0)->sortBy('order')->pluck('redirect_id', 'id')->all();

                foreach ($redirectIds as $key => $redirectId) {

                    if (!$lastResults->where('answer_id', $redirectId)->first()) {
                        $sectionIds = array_diff($sectionIds, [$key]);
                    }
                }
            }
        }
        $section = $this->surveyRepository->getSectionCurrent($survey, $sectionIds[0]);

        return [
            'survey' => $survey,
            'section' => $section,
            'index_section' => count($sectionIds) == 1 ? config('settings.index_section.end') : config('settings.index_section.start'),
            'section_ids' => $sectionIds,

        ];
    }
}
