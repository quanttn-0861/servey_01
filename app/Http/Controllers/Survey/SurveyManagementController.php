<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Survey\SurveyInterface;
use App\Repositories\Section\SectionInterface;
use App\Repositories\Question\QuestionInterface;
use App\Repositories\Answer\AnswerInterface;
use App\Repositories\Setting\SettingInterface;
use App\Repositories\Media\MediaInterface;
use App\Repositories\Result\ResultInterface;
use App\Repositories\Invite\InviteInterface;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Section;
use Exception, Auth, Datatables, Session, DB, Storage;
use Carbon\Carbon;
use App\Traits\SurveyProcesser;
use App\Traits\ManageSurvey;

class SurveyManagementController extends Controller
{
    use SurveyProcesser, ManageSurvey;

    protected $surveyRepository;
    protected $sectionRepository;
    protected $questionRepository;
    protected $answerRepository;
    protected $settingRepository;
    protected $mediaRepository;
    protected $resultRepository;
    protected $inviteRepository;

    public function __construct(
        SurveyInterface $surveyRepository,
        QuestionInterface $questionRepository,
        SectionInterface $sectionRepository,
        AnswerInterface $answerRepository,
        SettingInterface $settingRepository,
        MediaInterface $mediaRepository,
        ResultInterface $resultRepository,
        InviteInterface $inviteRepository
    ) {
        $this->surveyRepository = $surveyRepository;
        $this->questionRepository = $questionRepository;
        $this->sectionRepository = $sectionRepository;
        $this->answerRepository = $answerRepository;
        $this->settingRepository = $settingRepository;
        $this->mediaRepository = $mediaRepository;
        $this->resultRepository = $resultRepository;
        $this->inviteRepository = $inviteRepository;
    }

    public function showSurveys()
    {
        try {
            $user = Auth::user();
            $surveys = $this->surveyRepository->getAuthSurveys(config('settings.survey.members.owner'));

            return view('clients.profile.list-survey', compact('user', 'surveys'));
        } catch (Exception $e) {
            return view('clients.layout.404');
        }
    }

    public function deleteSurvey($token)
    {
        DB::beginTransaction();
        try {
            $survey = $this->surveyRepository->withTrashed()->where('token_manage', $token)->first();

            if (Auth::user()->cannot('delete', $survey)) {
                return view('clients.layout.403');
            }

            $this->delete($survey);

            DB::commit();

            return back()->with('success', trans('lang.delete_survey_success'));
        } catch (Exception $e) {
            DB::rollback();

            return back()->with('error', trans('lang.process_failed'));
        }
    }

    public function closeSurvey($token)
    {
        DB::beginTransaction();
        try {
            $survey = $this->surveyRepository->where('token_manage', $token)->first();

            if (Auth::user()->cannot('close', $survey)) {
                return view('clients.layout.403');
            }

            $this->close($survey);

            DB::commit();

            return back()->with('success', trans('lang.close_survey_success'));
        } catch (Exception $e) {
            DB::rollback();

            return back()->with('error', trans('lang.process_failed'));
        }
    }

    public function openSurvey($token)
    {
        DB::beginTransaction();
        try {
            $survey = $this->surveyRepository->onlyTrashed()->where('token_manage', $token)->first();

            if (Auth::user()->cannot('open', $survey)) {
                return view('clients.layout.403');
            }

            $this->open($survey);

            DB::commit();

            return back()->with('success', trans('lang.open_survey_success'));
        } catch (Exception $e) {
            DB::rollback();

            return back()->with('error', trans('lang.process_failed'));
        }
    }

    public function managementSurvey(Request $request, $tokenManage)
    {
        try {
            $survey = $this->surveyRepository->getSurveyFromTokenManage($tokenManage);
            $results = $this->getOverview($survey);

            if (Auth::user()->cannot('manage', $survey)) {
                return view('clients.layout.403');
            }

            return view('clients.survey.management.index', compact([
                'results',
                'survey'
            ]));
        } catch (Exception $e) {
            return view('clients.layout.404');
        }

    }
}
