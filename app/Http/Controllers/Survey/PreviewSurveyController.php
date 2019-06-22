<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cookie;
use Session;
use App\Traits\SurveyProcesser;
use Exception;

class PreviewSurveyController extends Controller
{
    use SurveyProcesser;

    public function getJson(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $data = $request->data;
        $request->session()->put('data_preview', $data);
        $request->session()->forget('section_id');
        $request->session()->forget('redirect_ids');

        return response()->json([
            'success' => true,
            'json' => $data,
        ]);
    }

    public function preview(Request $request)
    {
        try {
            $survey = json_decode($request->session()->get('data_preview'));
            $survey->background = $this->cutUrlImage($survey->background);
            $sectionId = $request->session()->has('section_id') ? $request->session()->get('section_id') : null;
            $redirectIds = $request->session()->has('redirect_ids') ? $request->session()->get('redirect_ids') : [null];

            if ($request->server->get('HTTP_CACHE_CONTROL') === config('settings.detect_page_refresh')) {
                $request->session()->forget('section_id');
                $request->session()->forget('redirect_ids');
                $sectionId = null;
                $redirectIds = [null];
            }

            $sections = collect($survey->sections)->whereIn('redirect_id', $redirectIds);
            $section = !$sectionId ? $sections->first() : $sections->where('id', $sectionId)->first();
            $checkIndexSection = config('settings.index_section.middle');
            $sectionIds = $sections->pluck('id')->all();
            $check = collect($sections->last()->questions)->where('type', config('settings.question_type.redirect'))->count();

            if ($sectionId && $sectionId == end($sectionIds) && !$check) {
                $checkIndexSection = config('settings.index_section.end');
            } elseif ($sectionId == $sectionIds[0] || !$sectionId) {
                $checkIndexSection = config('settings.index_section.start');
            }

            return view('clients.survey.create.preview', compact([
                    'survey',
                    'section',
                    'checkIndexSection',
                ])
            );
        } catch (Exception $e) {
            return redirect()->route('404');
        }
    }

    public function nextSection(Request $request, $id)
    {
        try {
            $survey = json_decode($request->session()->get('data_preview'));
            $sections = collect($survey->sections);
            $answerRedirectId = $request->answer_redirect_id ? $request->answer_redirect_id : null;
            $redirectIds = $request->session()->has('redirect_ids') ? $request->session()->get('redirect_ids') : [null];

            if ($answerRedirectId) {
                array_push($redirectIds, $answerRedirectId);
                $request->session()->put('redirect_ids', $redirectIds);
            }

            $sections = $sections->whereIn('redirect_id', $redirectIds);
            $sectionIds = $sections->pluck('id')->all();
            $index = array_search($id, $sectionIds);
            $sectionId = $sectionIds[$index + 1];
            $request->session()->put('section_id', $sectionId);

            return redirect()->route('survey.create.preview');
        } catch (Exception $e) {
            return redirect()->route('404');
        }
    }

    public function previousSection(Request $request, $id)
    {
        try {
            $survey = json_decode($request->session()->get('data_preview'));
            $sections = collect($survey->sections);
            $currentRedirectId = $request->current_redirect_id ? $request->current_redirect_id : null;
            $redirectIds = $request->session()->has('redirect_ids') ? $request->session()->get('redirect_ids') : [null];
            $sections = $sections->whereIn('redirect_id', $redirectIds);
            $sectionIds = $sections->pluck('id')->all();
            $index = array_search($id, $sectionIds);
            $sectionId = $sectionIds[$index - 1];
            $request->session()->put('section_id', $sectionId);
            $sectionRedirectIds = !is_null($currentRedirectId) ? $sections->where('redirect_id', $currentRedirectId)->pluck('id')->all() : [];

            if (count($sectionRedirectIds) && $sectionRedirectIds[0] == $id) {
                array_pop($redirectIds);
                $request->session()->put('redirect_ids', $redirectIds);
            }

            return redirect()->route('survey.create.preview');
        } catch (Exception $e) {
            return redirect()->route('404');
        }
    }
}
