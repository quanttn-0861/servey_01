<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\Survey\SurveyInterface;
use App\Repositories\User\UserInterface;
use Auth;
use Illuminate\Http\Response;
use App\Policies\SurveyPolicy;
use App\Traits\SurveyProcesser;

class DoingSurveyMiddleware
{
    use SurveyProcesser;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $surveyRepository;
    protected $userRepository;

    public function __construct(SurveyInterface $surveyRepository, UserInterface $userRepository)
    {
        $this->surveyRepository = $surveyRepository;
        $this->userRepository = $userRepository;
    }

    public function handle($request, Closure $next)
    {
        $survey = $this->surveyRepository->getSurveyFromToken($request->token);
        $status = $survey->status;
        $limitAnswer = $survey->getLimitAnswer();
        $title = $survey->title;

        if ($status != config('settings.survey.status.open')
            && (!Auth::check() || Auth::user()->cannot('edit', $survey))) {
            $content = trans('lang.you_do_not_have_permission');

            return new Response(view('clients.survey.detail.complete', compact('title', 'content')));
        }

        if (!Auth::check()) {
            $requiredLogin = $survey->required;
            $privacy = $survey->getPrivacy();

            if ($privacy == config('settings.survey_setting.privacy.private')) {
                $requiredLogin = config('settings.survey_setting.answer_required.login');
            }

            if ($requiredLogin) {
                return new Response(view('clients.survey.detail.index', compact('requiredLogin')));
            }
        }

        // process limit number of times answer if user login, if user is Incognito then not limit number answers
        if (Auth::check()) {
            $timesAnswer = $this->getResultsFollowOptionUpdate(
                $survey,
                $survey->results(),
                $this->userRepository
            );

            $timesAnswer = $timesAnswer->where('user_id', Auth::user()->id)
                ->pluck('created_at')
                ->unique()->count();

            if ($limitAnswer != config('settings.survey_setting.answer_unlimited') 
                && $timesAnswer >= $limitAnswer) {
                $content = trans('lang.has_replied_the_maximum_number_of_limit_replies');

                return  new Response(view('clients.survey.detail.complete', compact('title', 'content')));
            }
        }

        return $next($request);
    }
}
