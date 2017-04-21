<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Survey\SurveyInterface;
use App\Repositories\Question\QuestionInterface;
use App\Repositories\Invite\InviteInterface;
use App\Repositories\Setting\SettingInterface;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\SendMail;
use Carbon\Carbon;
use LRedis;
use Mail;
use DB;
use Validator;
use Exception;
use Session;

class SurveyController extends Controller
{
    use DispatchesJobs;

    protected $surveyRepository;
    protected $questionRepository;
    protected $inviteRepository;
    protected $settingRepository;

    public function __construct(
        SurveyInterface $surveyRepository,
        QuestionInterface $questionRepository,
        InviteInterface $inviteRepository,
        SettingInterface $settingRepository
    ) {
        $this->surveyRepository = $surveyRepository;
        $this->questionRepository = $questionRepository;
        $this->inviteRepository = $inviteRepository;
        $this->settingRepository = $settingRepository;
    }

    public function index()
    {
        return view('user.pages.home');
    }

    public function checkCloseSurvey($inviteIds, $surveyIds)
    {
        $ids = array_merge(
            $inviteIds->lists('survey_id')->toArray(),
            $surveyIds->lists('id')->toArray()
        );

        return $this->settingRepository
            ->whereIn('survey_id', $ids)
            ->where([
                'key' => config('settings.key.limitAnswer'),
                'value' => 0,
            ])
            ->lists('survey_id')
            ->toArray();
    }

    public function listSurveyUser(Request $request)
    {
        $invites = $inviteIds = $this->inviteRepository
            ->where('recevier_id', auth()->id())
            ->orWhere('mail', auth()->user()->email);
        $surveys = $surveyIds = $this->surveyRepository
            ->where('user_id', auth()->id());
        $settings = $this->checkCloseSurvey($inviteIds, $surveyIds);
        $invites = $invites
            ->orderBy('id', 'desc')
            ->paginate(config('settings.paginate'));
        $surveys = $surveys
            ->orderBy('id', 'desc')
            ->paginate(config('settings.paginate'));

        if ($request->ajax()) {
            try {
                $viewId = $request->get('viewId');
                $view = null;

                if ($viewId == 'profile-v') {
                    $view = view('user.pages.list-invited', compact('invites', 'settings'))->render();
                } elseif ($viewId == 'home-v') {
                    $view = view('user.pages.your_survey', compact('surveys', 'settings'))->render();
                }

                if (!$view) {
                    return response()->json([
                        'success' => false,
                        'messageFail' => trans('messages.paginate_fail'),
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'view' => $view,
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'messageFail' => trans('messages.paginate_fail'),
                ]);
            }
        }

        return view('user.pages.list-survey', compact('surveys', 'invites', 'settings'));
    }

    public function delete(Request $request)
    {
        if (!$request->ajax()) {
            return [
                'success' => false,
            ];
        }

        $surveyId = $request->get('idSurvey');
        $this->surveyRepository->delete($surveyId);
        $redis = LRedis::connection();
        $redis->publish('delete', json_encode([
            'success' => true,
            'surveyId' => $surveyId,
        ]));

        return [
            'success' => true,
        ];
    }

    public function show($token)
    {
        $surveys = $this->surveyRepository->where('token', $token)->first();

        if (!$surveys) {
            return view('errors.404');
        }

        return view('user.pages.answer', compact('surveys'));
    }

    public function updateSurvey(Request $request, $id)
    {
        $survey = $this->surveyRepository->find($id);
        $isSuccess = false;
        $data = $request->only([
            'title',
            'description',
        ]);

        if ($request->get('deadline')) {
            $data['deadline'] = Carbon::parse(in_array(Session::get('locale'), config('settings.sameFormatDateTime'))
                ? str_replace('-', '/', $data['deadline'])
                : $data['deadline'])
                ->toDateTimeString();
        }

        if ($survey) {
            DB::beginTransaction();
            try {
                $isSuccess = $this->surveyRepository->update($id, $data);
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }
        }

        $redis = LRedis::connection();
        $redis->publish('update', json_encode([
            'success' => true,
            'surveyId' => $id,
        ]));

        return redirect()->action('AnswerController@show', $survey->token_manage)
            ->with(($isSuccess) ? 'message' : 'message-fail', ($isSuccess)
                ? trans('messages.object_updated_successfully', [
                    'object' => class_basename(Survey::class),
                ])
                : trans('messages.object_updated_unsuccessfully', [
                    'object' => class_basename(Survey::class)
                ])
            );
    }

    public function updateSurveyContent(Request $request, $surveyId, $token)
    {
        DB::beginTransaction();
        try {
            $survey = $this->surveyRepository->find($surveyId);

            if (!$survey) {
                return view('errors.404');
            }

            if ($survey->update == config('survey.maxEdit')) {
                return redirect()->action('AnswerController@show', $token)
                    ->with('message-fail', trans('messages.object_updated_unsuccessfully', [
                        'object' => class_basename(Survey::class)
                ]));
            }

            $inputs = $request->only([
                'txt-question',
                'checkboxRequired',
                'required-question',
                'image',
                'image-url',
                'video-url',
                'del-question',
                'del-answer',
                'del-question-image',
                'del-answer-image',
            ]);
            $inputs['image-url'] = $this->removeEmptyValue($inputs['image-url']);
            $inputs['video-url'] = $this->removeEmptyValue($inputs['video-url']);
            $validator = $this->makeValidator([
                'txt-question' => $inputs['txt-question'],
                'image' => $inputs['image'],
            ]);
            $validator = Validator::make($request->all(), $validator);

            if ($validator->fails()) {
                return redirect()->action('AnswerController@show', $token)
                    ->with('message-fail', trans('messages.object_updated_unexicute', [
                        'object' => class_basename(Survey::class)
                ]));
            }

            $results = $this->questionRepository->updateSurvey($inputs, $surveyId);

            if (!$results['isEdit']) {
                return redirect()->action('AnswerController@show', $token)
                    ->with('message-fail', trans('messages.object_updated_unexicute', [
                        'object' => class_basename(Survey::class)
                ]));
            }

            $this->surveyRepository->update($survey->id, [
                'update' => $survey->update + 1,
            ]);
            $mailInput = [
                'title' => $survey->title,
                'description' => $survey->description,
                'link' => action($survey->feature
                        ? 'AnswerController@answerPublic'
                        : 'AnswerController@answerPrivate', [
                            'token' => $survey->token,
                    ]),
                'name' => $survey->user_name,
                'email' => $results['emails'],
            ];
            $job = (new SendMail(collect($mailInput), 'reAnswer'))
                ->onConnection('database')
                ->onQueue('emails');
            $this->dispatch($job);
            DB::commit();
            $redis = LRedis::connection();
            $redis->publish('update', json_encode([
                'success' => true,
                'surveyId' => $surveyId,
            ]));

            return redirect()->action('AnswerController@show', $token)
                ->with('message', trans('messages.object_updated_successfully', [
                    'object' => class_basename(Survey::class)
            ]));
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->action('AnswerController@show', $token)
                ->with('message-fail', trans('messages.object_updated_unsuccessfully', [
                    'object' => class_basename(Survey::class)
            ]));
        }
    }

    private function makeValidator(array $inputs, $flage = false)
    {
        $images = $inputs['image'];
        $validator = [];

        foreach ($inputs['txt-question']['question'] as $questionIndex => $content) {
            $validator['txt-question.question.' . $questionIndex] = 'required|max:255';

            if ($images && array_key_exists('question', $images) && array_key_exists($questionIndex, $images['question'])) {
                $validator['image.quesion.' . $questionIndex] = 'image|mimes:jpg,jpeg,png,gif,svg|max:1000';
            }

            foreach ($inputs['txt-question']['answers'][$questionIndex] as $answerIndex => $answer) {
                $type = head(array_keys($answer));

                if (in_array($type, [
                    config('survey.type_radio'),
                    config('survey.type_checkbox'),
                ])) {
                    $validator['txt-question.answers.' . $questionIndex . '.' . $answerIndex . '.' . $type] = 'required|max:255';
                }

                if ($images
                    && array_key_exists('answers', $images)
                    && array_key_exists($questionIndex, $images['answers'])
                    && array_key_exists($answerIndex, $images['answers'][$questionIndex])
                ) {
                    $validator['image.answers.' . $questionIndex . '.' . $answerIndex] = 'image|mimes:jpg,jpeg,png,gif,svg|max:1000';
                }
            }
        }

        if ($flage) {
            $validator['email'] = 'required|email|max:255';
            $validator['name'] = 'required|max:255';
            $validator['emails'] = 'max:255
                |regex:/^([a-zA-Z0-9_.+-][a-z0-9_\.]{0,}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}[,]{0,1}[,]{0,1}[\s]*)+(?<!,)(?<!\s)$/';
            $validator['title'] = 'required|max:255';
            $realTime = Carbon::now()->addMinutes(30)->format(trans('temp.format_with_trans'));
            $validator['deadline'] = 'date_format:' . trans('temp.format_with_trans') . '|after:' . $realTime;
        }

        return $validator;
    }

    private function removeEmptyValue(array $array)
    {
        if (array_key_exists('question', $array)) {
            $array['question'] = array_filter($array['question']);
        }

        if (array_key_exists('answers', $array)) {
            foreach (array_keys($array['answers']) as $key) {
                $array['answers'][$key] = array_filter($array['answers'][$key]);
            }
        }

        return $array;
    }

    public function create(Request $request)
    {
        $value = $request->only([
            'title',
            'feature',
            'deadline',
            'description',
            'txt-question',
            'checkboxRequired',
            'email',
            'emails',
            'setting',
            'name',
            'image',
            'image-url',
            'video-url',
        ]);

        $validator = $this->makeValidator([
            'txt-question' => $value['txt-question'],
            'image' => $value['image'],
        ], true);
        $validator = Validator::make($request->all(), $validator);

        if ($validator->fails()) {
            return redirect()->action('SurveyController@index')
                ->with('message-fail', trans('messages.object_created_unsuccessfully', [
                    'object' => class_basename(Survey::class),
            ]));
        }

        if (!strlen($value['title'])) {
            $value['title'] = config('survey.title_default');
        }

        $token = md5(uniqid(rand(), true));
        $tokenManage = md5(uniqid(rand(), true));

        DB::beginTransaction();
        try {
            $inputs = collect([
                'user_id' => (auth()->id()) ? auth()->id() : null,
                'mail' => (!auth()->id()) ? $value['email'] : null,
                'title' => $value['title'],
                'feature' => $value['feature'],
                'token' => $token,
                'token_manage' => $tokenManage,
                'status' => $value['deadline'],
                'deadline' => $value['deadline'],
                'description' => $value['description'],
                'user_name' => $value['name'],
            ]);
            $survey = $this->surveyRepository->createSurvey(
                $inputs,
                ($value['setting']) ?: [],
                $value['txt-question'],
                ($value['checkboxRequired']['question']) ?: [],
                ($value['image']) ?: [],
                $this->removeEmptyValue($value['image-url']),
                $this->removeEmptyValue($value['video-url']),
                Session::get('locale')
            );

            if ($survey) {
                $inputInfo = $request->only([
                    'name',
                    'email',
                    'title',
                    'description',
                ]);
                $inputInfo['link'] = action($inputs['feature']
                    ? 'AnswerController@answerPublic'
                    : 'AnswerController@answerPrivate', [
                        'token' => $token,
                ]);
                $inputInfo['linkManage'] = action('AnswerController@show', [
                    'tokenManage' =>  $tokenManage,
                ]);
                $job = (new SendMail(collect($inputInfo), 'mailManage'))
                    ->onConnection('database')
                    ->onQueue('emails');
                $isSuccess = ($this->dispatch($job) && $this->inviteUser($request, $survey, config('settings.return.bool')));

                if (!$isSuccess) {
                    DB::rollback();

                    return redirect()->action('SurveyController@index')
                        ->with('message-fail', trans('messages.object_created_unsuccessfully', [
                            'object' => class_basename(Survey::class),
                    ]));
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->action('SurveyController@index')
                ->with('message-fail', trans('messages.object_created_unsuccessfully', [
                    'object' => class_basename(Survey::class),
            ]));
        }

        return redirect()->action('SurveyController@complete', [
            $tokenManage,
            $value['name'],
        ]);
    }

    public function complete($token, $name)
    {
        if (!$token || !$name) {
            return view('errors.404');
        }

        $survey = $this->surveyRepository->where('token_manage', $token)->first();

        if (!$survey) {
            return view('errors.404');
        }

        $mail = auth()->check() ? auth()->user()->email : $survey->mail;

        return view('user.pages.complete', compact('survey', 'name', 'mail'));
    }

    public function inviteUser(Request $request, $surveyId, $type)
    {
        // type nếu là bool thì hàm inviteUser sẽ trả về true hoặc flase, view thì hàm inviteUser sẽ trả về action('SurveyController@listSurveyUser')
        $isSuccess = false;
        $data['email'] = $request->get(($type == config('settings.return.bool')) ? 'email' : 'emailUser') ?: auth()->user()->email;
        $data['emails'] = $request->get(($type == config('settings.return.bool')) ? 'emails' : 'emailsUser');
        $data['feature'] = $request->get('feature');

        if (empty($data['emails'])) {
            return true;
        }

        $data['emails'] = explode(',', $data['emails']);

        if ($data['emails'] && $surveyId) {
            $survey = $this->surveyRepository->find($surveyId);
            $data['name'] = $survey->user_name;
            $invite = $this->inviteRepository
                ->invite(auth()->id(), $data['emails'], $surveyId);
            $data['feature'] = ($type == config('settings.return.bool')) ? $data['feature'] : $survey->feature;

            if ($invite) {
                $inputInfo = [
                    'name' => auth()->check() ? auth()->user()->name : $data['name'],
                    'email' => $data['emails'],
                    'title' => $survey->title,
                    'description' => $survey->description,
                    'link' => action($survey->feature
                        ? 'AnswerController@answerPublic'
                        : 'AnswerController@answerPrivate', [
                            'token' => $survey->token,
                    ]),
                    'emailSender' => $data['email'],
                ];
                $job = (new SendMail(collect($inputInfo), 'mailInvite'))
                    ->onConnection('database')
                    ->onQueue('emails');
                $this->dispatch($job);
                $isSuccess = true;
            }
        }

        if (!auth()->check() && $type == config('settings.return.view')) {
            return $isSuccess
                ? redirect()->action('AnswerController@show', $survey->token_manage)
                    ->with('message', trans('survey.invite_success'))
                : redirect()->action('AnswerController@show', $survey->token_manage)
                    ->with('message-fail', trans('survey.invite_fail'));
        }

        return ($type == config('setttings.return.bool')) ? $isSuccess : ($isSuccess)
            ? redirect()->action('SurveyController@listSurveyUser')
                ->with('message', trans('survey.invite_success'))
            : redirect()->action('SurveyController@listSurveyUser')
                ->with('message-fail', trans('survey.invite_fail'));
    }
}
