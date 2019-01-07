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
        $request->Session()->put('data_preview', $data);

        return response()->json([
            'success' => true,
            'json' => $data,
        ]);
    }

    public function preview(Request $request)
    {
        try {
            $survey = json_decode(Session::get('data_preview'));
            $sectionId = Cookie::has('section_id') ? Cookie::get('section_id') : null;
            $redirectIds = Cookie::has('redirect_ids') ? Cookie::get('redirect_ids') : [null];

            if ($request->server->get('HTTP_CACHE_CONTROL') === config('settings.detect_page_refresh')) {
                Cookie::queue(Cookie::forget('redirect_ids'));
                Cookie::queue(Cookie::forget('section_id'));
                $sectionId = null;
                $redirectIds = [null];
            }

            $sections = collect($survey->sections)->whereIn('redirect_id', $redirectIds);
            $section = !$sectionId ? $sections->first() : $sections->where('id', $sectionId)->first();
            $checkIndexSection = config('settings.index_section.middle');
            $sectionIds = $sections->pluck('id')->all();

            if($sectionId && $sectionId == end($sectionIds)) {
                $checkIndexSection = config('settings.index_section.end');
            } elseif ($sectionId == $sectionIds[0]) {
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
            $survey = json_decode(Session::get('data_preview'));
            $sections = collect($survey->sections);
            $answerRedirectId = $request->answer_redirect_id ? $request->answer_redirect_id : null;
            $redirectIds = Cookie::has('redirect_ids') ? Cookie::get('redirect_ids') : [null];

            if ($answerRedirectId) {
                array_push($redirectIds, $answerRedirectId);
                Cookie::queue(Cookie::make('redirect_ids', $redirectIds, 60));
            }

            $sections = $sections->whereIn('redirect_id', $redirectIds);
            $sectionIds = $sections->pluck('id')->all();
            $index = array_search($id, $sectionIds);
            $sectionId = $sectionIds[$index + 1];
            Cookie::queue(Cookie::make('section_id', $sectionId, 60));

            return redirect()->route('survey.create.preview');
        } catch (Exception $e) {
            return redirect()->route('404');
        }
    }

    public function previousSection(Request $request, $id)
    {
        try {
            $survey = json_decode(Session::get('data_preview'));
            $sections = collect($survey->sections);
            $currentRedirectId = $request->current_redirect_id ? $request->current_redirect_id : null;
            $redirectIds = Cookie::has('redirect_ids') ? Cookie::get('redirect_ids') : [null];
            $sections = $sections->whereIn('redirect_id', $redirectIds);
            $sectionIds = $sections->pluck('id')->all();
            $index = array_search($id, $sectionIds);
            $sectionId = $sectionIds[$index - 1];
            Cookie::queue(Cookie::make('section_id', $sectionId, 60));
            $sectionRedirectIds = !is_null($currentRedirectId) ? $sections->where('redirect_id', $currentRedirectId)->pluck('id')->all() : [];

            if (count($sectionRedirectIds) && $sectionRedirectIds[0] == $id) {
                array_pop($redirectIds);
                Cookie::queue(Cookie::make('redirect_ids', $redirectIds, 60));
            }

            return redirect()->route('survey.create.preview');
        } catch (Exception $e) {
            return redirect()->route('404');
        }
    }
}
