<?php

namespace App\Http\Controllers\Survey;

use App\Repositories\Section\SectionInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Survey\SurveyInterface;
use App\Repositories\Result\ResultInterface;
use App\Repositories\User\UserInterface;
use Exception;
use Auth;
use Carbon\Carbon;

class ResultController extends Controller
{
    protected $surveyRepository;
    protected $resultRepository;
    protected $userRepository;
    protected $sectionRepository;

    public function __construct(
        SurveyInterface $surveyRepository,
        ResultInterface $resultRepository,
        UserInterface $userRepository,
        SectionInterface $sectionRepository
    ) {
        $this->surveyRepository = $surveyRepository;
        $this->resultRepository = $resultRepository;
        $this->userRepository = $userRepository;
        $this->sectionRepository = $sectionRepository;
    }

    public function result(Request $request, $tokenManage)
    {
        try {
            $survey = $this->surveyRepository->getSurveyForResult($tokenManage);

            if (Auth::user()->cannot('viewResult', $survey)) {
                return view('clients.layout.403');
            }

            $resultsSurveys = $this->surveyRepository->getResutlSurvey($survey, $this->userRepository);
            $startTimeStr = $survey->start_time;
            $months = [];

            if ($startTimeStr) {
                $startTime = new Carbon($startTimeStr);
                $now = Carbon::now();
                $endTime = new Carbon($survey->end_time);
                $endTime = ($endTime < $now) ? $endTime : $now;
                $numberMonth = $startTime->diffInMonths($endTime);
                $months[''] = trans('lang.all');

                for ($index = 0; $index <= $numberMonth; ++ $index) {
                    $value = new Carbon($startTimeStr);
                    $value = $value->addMonth($index);
                    $value = $value->format('m-Y');
                    $months[$value] = $value;
                }
            }

            if ($request->ajax()) {
                $redirectQuestionIds = $this->surveyRepository->getRedirectQuestionIds($survey);
                $publicResults = $this->surveyRepository->getPublicResults($survey);

                return response()->json([
                    'success' => true,
                    'html' => view('clients.survey.result.content_result', compact([
                        'survey',
                        'resultsSurveys',
                        'months',
                        'redirectQuestionIds',
                        'publicResults'
                    ]))->render(),
                ]);
            }

            return view('clients.survey.result.index', compact('survey', 'resultsSurveys', 'months'));
        } catch (Exception $e) {
            return view('clients.layout.404');
        }
    }

    public function detail(Request $request, $tokenManage)
    {
        try {
            $survey = $this->surveyRepository->getSurveyForResult($tokenManage);

            if (Auth::user()->cannot('viewResult', $survey)) {
                return view('clients.layout.403');
            }

            $data = $this->resultRepository->getDetailResultSurvey($request, $survey, $this->userRepository);
            $details = $data['results'];
            $countResult = $data['countResult'];
            $pageCurrent = isset($request->page) ? $request->page : 1;

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'html' => view('clients.survey.result.content-detail', compact([
                        'survey',
                        'countResult',
                        'details',
                        'pageCurrent',
                    ]))->render(),
                ]);
            }

            return view('clients.survey.result.detail', compact([
                'survey',
                'countResult',
                'details',
                'pageCurrent',
            ]));
        } catch (Exception $e) {

            return view('clients.layout.404');
        }
    }

    public function getRedirectResult(Request $request)
    {
        try {
            $redirectSection = $this->sectionRepository->getSectionFromRedirectId($request->id);
            $survey = $redirectSection->survey;
            $resultsSurveys = $this->surveyRepository->getResultFromRedirectSection($redirectSection, $this->userRepository);
            $publicResults = $this->surveyRepository->getPublicResults($survey);

            return response()->json([
                'success' => true,
                'html' => view('clients.survey.result.redirect_result', compact([
                    'resultsSurveys',
                    'publicResults'
                ]))->render(),
            ]);
        } catch (Exception $e) {
            return view('clients.layout.404');
        }
    }
}
