<?php

namespace App\Repositories\Section;

use App;
use Exception;
use App\Models\Section;
use Illuminate\Support\Collection;
use App\Repositories\BaseRepository;
use App\Repositories\Question\QuestionInterface;

class SectionRepository extends BaseRepository implements SectionInterface
{
    public function getModel()
    {
        return Section::class;
    }

    public function deleteSections($ids)
    {
        $ids = is_array($ids) ? $ids : [$ids];
        $questionIds = app(QuestionInterface::class)->whereIn('section_id', $ids)->pluck('id')->all();
        app(QuestionInterface::class)->deleteQuestions($questionIds);

        return $this->model->whereIn('id', $ids)->delete();
    }

    public function closeFromSurvey($survey)
    {
        return $survey->sections()->delete();
    }

    public function openFromSurvey($survey)
    {
        return $survey->sections()->onlyTrashed()->restore();
    }

    public function deleteFromSurvey($survey)
    {
        return $survey->sections()->withTrashed()->forceDelete();
    }

    public function cloneSection($section, $newSurvey)
    {
        $newSection = $section->replicate()->toArray();
        $newSection['update'] = config('settings.survey.section_update.default');

        return $newSurvey->sections()->create($newSection);
    }

    public function getSectionFromRedirectId($redirectId)
    {
        return $this->model->withTrashed()->where('redirect_id', $redirectId)->first();
    }
}
