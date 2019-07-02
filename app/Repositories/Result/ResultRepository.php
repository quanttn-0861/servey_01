<?php

namespace App\Repositories\Result;

use App\Models\Result;
use App\Repositories\BaseRepository;
use App\Traits\ClientInformation;
use App\Traits\SurveyProcesser;
use Exception;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class ResultRepository extends BaseRepository implements ResultInterface
{
    use ClientInformation, SurveyProcesser;

    public function getModel()
    {
        return Result::class;
    }

    public function storeResult($data, $survey)
    {
        $surveyToken = $data->get('survey_token');
        $survey = $survey->getSurveyFromToken($surveyToken);
        $survey = $survey->load('results', 'settings', 'invite');

        $clientInfo = $this->processAnswererInformation($data, $survey, $survey->getPrivacy());
        $tokenResult = md5(uniqid(rand(), true));
        $resultsData = [];
        $sections = $data->get('sections');

        foreach ($sections as $section) {
            $temp = [];

            foreach ($section['questions'] as $question) {
                $temp['question_id'] = $question['question_id'];

                foreach ($question['results'] as $result) {
                    $temp['answer_id'] = 0;
                    $temp['content'] = '';
                    $temp['token'] = $tokenResult;

                    if (in_array($question['type'], [
                        config('settings.question_type.short_answer'),
                        config('settings.question_type.long_answer'),
                        config('settings.question_type.date'),
                        config('settings.question_type.time'),
                        config('settings.question_type.linear_scale'),
                        config('settings.question_type.grid'),
                    ])) {
                        $temp['content'] = $result['content'];
                    } elseif ($result['answer_id']) {
                        $temp['answer_id'] = $result['answer_id'];

                        if ($result['answer_type'] == config('settings.answer_type.other_option')) {
                            $temp['content'] = $result['content'];
                        }
                    }

                    array_push($resultsData, array_merge($temp, $clientInfo));
                }
            }
        }

        $inviter = $survey->invite;
        $sendUpdateMails = collect(!empty($inviter) ? $inviter->send_update_mails_array : []);
        $userMails = Auth::check() ? Auth::user()->email : '';

        // when update result with option update is "only send question update", if user answer many times then delete old results
        if ($survey->isSendUpdateOption() && $sendUpdateMails->contains($userMails)) {
            $timesAnswer = $survey->results->where('user_id', Auth::user()->id)
                ->pluck('token')
                ->unique()->count();

            if ($timesAnswer > 1) {
                $newestCreated = $survey->results->where('user_id', Auth::user()->id)
                    ->sortByDesc('created_at')
                    ->first()->token;

                $survey->results()->where('user_id', Auth::user()->id)
                    ->where('token', '!=', $newestCreated)->forceDelete();
            }
        }

        $survey->results()->createMany($resultsData);

        // update created_at of pairs result has updated
        if ($survey->isSendUpdateOption() && $sendUpdateMails->contains($userMails)) {
            $results = $survey->results()->where('user_id', $clientInfo['user_id'])
                ->orderBy('created_at', 'desc')->get();
            $token = $results->first()->token;
            $createdAt = $results->first()->created_at;
            $resultsId = $results->pluck('id');

            DB::table('results')->whereIn('id', $resultsId)->update([
                'token' => $token,
                'created_at' => $createdAt,
            ]);
        }

        return $tokenResult;
    }

    // === old ===
    public function create($answers)
    {
        $input = [];
        foreach ($answers as $answer) {
            $input[] = [
                'sender_id' => $senderId,
                'recever_id' => $receverId,
                'answer_id' => $answer->id,
            ];
        }

        $this->multiCreate($input);
    }

    public function getDetailResultSurvey($request, $survey, $userRepo)
    {
        $results = $survey->results();
        $results = $this->getResultsFollowOptionUpdate($survey, $results, $userRepo)->get();
        $countSection = count($survey->sections->where('redirect_id', config('settings.number_0')));

        $results = $results->groupBy('token');

        $countResult = $results->count();
        $page = isset($request->page) ? $request->page : 1;
        $perPage = 1;

        $paginate = new LengthAwarePaginator(
            $results->forPage($page, $perPage),
            $results->count(),
            $perPage,
            $page,
            ['path' => route('survey.result.detail-result', $survey->token_manage)]
        );

        return [
            'results' => $paginate,
            'countResult' => $countResult,
            'countSection' => $countSection,
        ];
    }

    public function closeFromSurvey($survey)
    {
        return $survey->results()->delete();
    }

    public function openFromSurvey($survey)
    {
        return $survey->results()->onlyTrashed()->restore();
    }

    public function deleteFromSurvey($survey)
    {
        return $survey->results()->withTrashed()->forceDelete();
    }

    public function getResultFromToken($token, $sections)
    {
        $results = [];

        foreach ($sections as $section) {
            $results[$section->id] = $this->model->withTrashed()->where('token', $token)
                ->whereIn('question_id', $section->questions->pluck('id')->all())->get();
        }

        return $results;
    }

    public function getNewResults($data, $currentResult)
    {
        $sections = $data->get('sections');
        $tokenResult = $currentResult->token;
        $clientIp = $currentResult->client_ip;
        $userId = $currentResult->user_id;
        $newResultsData = [];

        foreach ($sections as $section) {
            $temp = [];
            
            foreach ($section['questions'] as $key => $question) {
                $temp['question_id'] = $question['question_id'];

                foreach ($question['results'] as $result) {
                    $temp['answer_id'] = 0;
                    $temp['content'] = '';
                    $temp['token'] = $tokenResult;
                    $temp['user_id'] = $userId;
                    $temp['client_ip'] = $clientIp;

                    if (in_array($question['type'], [
                        config('settings.question_type.short_answer'),
                        config('settings.question_type.long_answer'),
                        config('settings.question_type.date'),
                        config('settings.question_type.time'),
                        config('settings.question_type.linear_scale'),
                        config('settings.question_type.grid'),
                    ])) {
                        $temp['content'] = $result['content'];
                    } elseif ($result['answer_id']) {
                        $temp['answer_id'] = $result['answer_id'];

                        if ($result['answer_type'] == config('settings.answer_type.other_option')) {
                            $temp['content'] = $result['content'];
                        }
                    }

                    array_push($newResultsData, $temp);
                }
            }
        }

        return $newResultsData;
    }

    public function updateNewResults($newResultsData, $currentResults, $survey)
    {
        $allSectionRedirectIds = $survey->sections->where('redirect_id', '<>', 0)->pluck('id')->all();
        $allQuestionRedirectIds = $survey->questions->whereIn('section_id', $allSectionRedirectIds)->pluck('id')->all();

        foreach ($survey->questions as $question) {

            if (in_array($question->type, [
                config('settings.question_type.image'),
                config('settings.question_type.video'),
                config('settings.question_type.title'),
            ]) || in_array($question->id, $allQuestionRedirectIds)) {
                continue;
            }

            if ($question->type == config('settings.question_type.checkboxes')) {
                $oldResults = $currentResults->where('question_id', $question->id);

                foreach ($oldResults as $oldResult) {
                    $oldResult->forceDelete();
                }
                $survey->results()->createMany(collect($newResultsData)->where('question_id', $question->id)->toArray());
            } else {
                $result = collect($newResultsData)->where('question_id', $question->id)->first();
                $currentResults->where('question_id', $question->id)->first()->update($result);

                if ($question->type == config('settings.question_type.redirect')) {
                    $sectionRedirectIds = $survey->sections->whereIn('redirect_id', $question->answers->pluck('id')->all())->pluck('id')->all();
                    $questionRedirectIds = $survey->questions->whereIn('section_id', $sectionRedirectIds)->pluck('id')->all();
                    $oldRedirectResults = $currentResults->whereIn('question_id', $questionRedirectIds);

                    foreach ($oldRedirectResults as $oldRedirectResult) {
                        $oldRedirectResult->forceDelete();
                    }
                    $questionIds = $survey->sections->where('redirect_id', $result['answer_id'])->first()->questions->pluck('id')->all();
                    $survey->results()->createMany(collect($newResultsData)->whereIn('question_id', $questionIds)->toArray());
                }
            }
        }
    }
}
