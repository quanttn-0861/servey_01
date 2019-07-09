<?php

namespace App\Repositories\Answer;

use App\Models\Answer;
use App\Models\Result;
use App\Models\Setting;
use App\Repositories\BaseRepository;
use App\Repositories\Result\ResultInterface;
use App\Repositories\Setting\SettingInterface;
use App\Repositories\Media\MediaInterface;
use Illuminate\Support\Collection;
use DB;
use Storage;
use Exception;
use Carbon\Carbon;

class AnswerRepository extends BaseRepository implements AnswerInterface
{
    public function getModel()
    {
        return Answer::class;
    }

    public function deleteByQuestionId($questionIds)
    {
        $ids = is_array($questionIds) ? $questionIds : [$questionIds];
        $answers = $this->whereIn('question_id', $ids)->lists('id')->toArray();
        app(ResultInterface::class)
            ->delete(app(ResultInterface::class)->whereIn('answer_id', $answers)->lists('id')->toArray());
        parent::delete($answers);
    }

    public function getAnswerIds($questionIds, $update = false)
    {
        if (!$update) {
            return $this->whereIn('question_id', $questionIds)
                ->whereNotIn('update', [
                    config('survey.update.change'),
                    config('survey.update.delete'),
                ])
                ->pluck('id')
                ->toArray();
        }

        return $this->whereIn('question_id', $questionIds)->lists('id')->toArray();
    }

    public function getResultByAnswer($questionIds, $time = null, $isUpdate = false)
    {
        $answerIds = $this->getAnswerIds($questionIds, $isUpdate);

        if (!$time) {
            return app(ResultInterface::class)->whereIn('answer_id', $answerIds);
        }

        $time = Carbon::parse($time)->format('Y-m-d');

        return app(ResultInterface::class)
            ->whereIn('answer_id', $answerIds)
            ->where('created_at', 'LIKE', "%$time%");
    }

    public function deleteResultWhenUpdateAnswer($ids)
    {
        app(ResultInterface::class)->newQuery(new Result());
        $results = app(ResultInterface::class)->whereIn('answer_id', is_array($ids) ? $ids : [$ids])->lists('email', 'id')->toArray();
        $ids = array_keys($results);
        $emails = array_where($results, function($value, $key) {
            if ($value != (string)config('settings.undentified_email')) {
                return $value;
            }
        });
        app(ResultInterface::class)->newQuery(new Result());
        app(ResultInterface::class)->delete($ids);

        return $emails;
    }

    public function createOrUpdateAnswer(array $answers, array $data)
    {
        $questionId = $data['questionId'];
        $answersInQuestion = $data['answersInQuestion'];
        $collectAnswer = $data['collectAnswer'];
        $imagesAnswer = $data['imagesAnswer'];
        $deleteImageIds = $data['deleteImageIds'];
        $isEdit = $data['isEdit'];
        $imageUrlAnswer = $data['imageUrlAnswer'];
        $videoUrlAnswer = $data['videoUrlAnswer'];

        if ($answers[$questionId] && $answersInQuestion && !$answersInQuestion->isEmpty()) {
            $dataCreate = [];
            $index = 0;
            $maxUpdate = $answersInQuestion->max('update');
            $arrayInfoUpdate = $answers[$questionId];
            // check image answer is exists in question
            $checkImages = ($imagesAnswer && array_key_exists($questionId, $imagesAnswer));
            // remove if last index of answer[$question] is other radio or other checkbox in last list answer

            if (in_array(head(array_keys(last($arrayInfoUpdate))), [
                config('survey.type_other_radio'),
                config('survey.type_other_checkbox'),
            ])) {
                end($answers[$questionId]);
                $key = key($answers[$questionId]);
                $arrayInfoUpdate = array_except($arrayInfoUpdate, [$key]);
            }

            foreach ($answersInQuestion->values() as $indexAnswer => $answer) {
                $updateAnswer = [];
                $questionId = $answer->question_id;
                $typeAnswer = $answer->type;
                $updateAnswer['content'] = $arrayInfoUpdate[$index][$typeAnswer];

                if (in_array($answer->id, $deleteImageIds)) {
                    $updateAnswer['image'] = null;
                }

                // check the answer is have image
                $checkHaveImage = ($checkImages && array_key_exists($indexAnswer, $imagesAnswer[$questionId]));

                if ($checkHaveImage) {
                    $updateAnswer['image'] = $this
                        ->uploadImage($imagesAnswer[$questionId][$indexAnswer], config('settings.image_answer_path'));
                }

                if (array_has($imageUrlAnswer, $indexAnswer)) {
                    $updateAnswer['image'] = $this->uploadImageUrl($imageUrlAnswer[$indexAnswer], config('settings.image_answer_path'));
                }


                if (array_has($videoUrlAnswer, $indexAnswer)) {
                    $updateAnswer['video'] = $videoUrlAnswer[$indexAnswer];
                }

                $modelAnswer = $answer->fill($updateAnswer);

                if ($modelAnswer->getDirty()) {
                    $dataCreate[] = [
                        'content' => $modelAnswer->content,
                        'type' => $modelAnswer->type,
                        'question_id' => $modelAnswer->question_id,
                        'image' => $modelAnswer->image_update,
                        'video' => $modelAnswer->video,
                        'update' => $maxUpdate + 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'clone_id' => $modelAnswer->clone_id ?: $modelAnswer->id,
                    ];
                    $modelAnswer->fill($modelAnswer->getOriginal());
                    $modelAnswer->update = config('survey.update.change');
                    $modelAnswer->save();
                    $isEdit = true;
                }

                $answers[$questionId] = array_except($answers[$questionId], [$indexAnswer]);
                $index++;
            }

            $check = $collectAnswer[$questionId]->whereIn('type', [
                config('survey.type_other_radio'),
                config('survey.type_other_checkbox'),
            ]);

            if (!$check->isEmpty()) {
                end($answers[$questionId]);
                $key = key($answers[$questionId]);
                $answers[$questionId] = array_except($answers[$questionId], [$key]);
            }

            if ($answersCreate = $answers[$questionId]) {
                foreach ($answersCreate as $indexAnswer => $answer) {
                    $checkHaveImage = ($checkImages && array_key_exists($indexAnswer, $imagesAnswer[$questionId]));

                    if ($answer) {
                        $content = in_array(head(array_keys($answer)), [
                            config('survey.type_other_checkbox'),
                            config('survey.type_other_radio'),
                        ]) ? trans('temp.other') : head($answer);
                        $dataCreate[] = [
                            'content' => $content,
                            'question_id' => $questionId,
                            'type' => head(array_keys($answer)),
                            'image' => $checkHaveImage
                                ? $this->uploadImage($imagesAnswer[$questionId][$indexAnswer], config('settings.image_answer_path'))
                                : $this->uploadImageUrl(array_get($imageUrlAnswer, $indexAnswer), config('settings.image_answer_path')),
                            'video' => array_get($videoUrlAnswer, $indexAnswer),
                            'update' => $maxUpdate + 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'clone_id' => 0, // the dataCreate must be same key
                        ];
                    }
                }

                $isEdit = true;
            }

            $this->multiCreate($dataCreate);
        }

        return [
            'success' => true,
            'answers' => $answers,
            'isEdit' => $isEdit,
        ];
    }

    public function deleteFromQuestionId($idQuestions)
    {
        if (!empty($idQuestions)) {
            $answers = $this->model->withTrashed()->whereIn('question_id', $idQuestions);

            $answers->each(function ($answer) {
                $answer->settings()->withTrashed()->forceDelete();
                $answer->media()->withTrashed()->forceDelete();
            });

            return $answers->forceDelete();
        }
    }

    public function closeFromQuestionId($idQuestions)
    {
        if (!empty($idQuestions)) {
            $answers = $this->model->whereIn('question_id', $idQuestions);

            $answers->get()->each(function ($answer) {
                $answer->settings()->delete();
                $answer->media()->delete();
            });

            return $answers->delete();
        }
    }

    public function openFromQuestionId($idQuestions)
    {
        if (!empty($idQuestions)) {
            $answers = $this->model->onlyTrashed()->whereIn('question_id', $idQuestions);

            $answers->get()->each(function ($answer) {
                $answer->settings()->onlyTrashed()->restore();
                $answer->media()->onlyTrashed()->restore();
            });

            return $answers->restore();
        }
    }

    public function deleteAnswersById($idAnswers)
    {
        $idAnswers = is_array($idAnswers) ? $idAnswers : [$idAnswers];
        
        DB::table('media')->where('mediable_type', Answer::class)
            ->whereIn('mediable_id', $idAnswers)->delete();

        DB::table('settings')->where('settingable_type', Answer::class)
            ->whereIn('settingable_id', $idAnswers)->delete();

        DB::table('answers')->whereIn('id', $idAnswers)->delete(); 
    }

    public function cloneAnswer(&$redirectIds, $answer, $newQuestion)
    {
        $data = $answer->replicate()->toArray();
        $data['update'] = config('settings.survey.answer_update.default');
        $newAnswer = $newQuestion->answers()->create($data);        
        // clone setting answer
        $dataSettings = $answer->settings->toArray();
        $newAnswer->settings()->createMany($dataSettings);
        // clone media answer
        $dataMedia = $answer->media->toArray();
        app(MediaInterface::class)->cloneMedia($dataMedia, $newAnswer);

        if ($newQuestion->type == config('settings.question_type.redirect')) {
            $redirectIds[$answer->id] = $newAnswer->id;
        }

        return $newAnswer;
    }
}
