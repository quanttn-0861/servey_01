<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElementFetchingController extends Controller
{
    public function fetchSection(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $numberOfSections = $request->numberOfSections;
        $sectionId = $request->sectionId;
        $questionId = $request->questionId;
        $answerId = $request->answerId;
        $optionId = config('settings.survey.option.first');

        return response()->json([
            'success' => true,
            'html' => view('clients.survey.elements.section', compact(
                'numberOfSections',
                'sectionId',
                'questionId',
                'answerId',
                'optionId'
            ))->render(),
        ]);
    }

    public function fetchTitleDescription(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $sectionId = $request->sectionId;
        $questionId = $request->questionId;

        return response()->json([
            'success' => true,
            'html' => view('clients.survey.elements.title-description', compact(
                'sectionId',
                'questionId'
            ))->render(),
        ]);
    }

    public function fetchShortAnswer(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $sectionId = $request->sectionId;
        $questionId = $request->questionId;
        $imageURL = $request->imageURL;

        $image = $imageURL ? view('clients.survey.elements.image-question', compact('imageURL'))->render() : '';

        return response()->json([
            'success' => true,
            'html' => view('clients.survey.elements.short-answer', compact(
                'sectionId',
                'questionId',
                'imageURL'
            ))->render(),
            'image' => $image,
        ]);
    }

    public function fetchLongAnswer(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $sectionId = $request->sectionId;
        $questionId = $request->questionId;
        $imageURL = $request->imageURL;

        $image = $imageURL ? view('clients.survey.elements.image-question', compact('imageURL'))->render() : '';

        return response()->json([
            'success' => true,
            'html' => view('clients.survey.elements.long-answer', compact(
                'sectionId',
                'questionId',
                'imageURL'
            ))->render(),
            'image' => $image,
        ]);
    }

    public function fetchMultipleChoice(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $sectionId = $request->sectionId;
        $questionId = $request->questionId;
        $answerId = $request->answerId;
        $optionId = config('settings.survey.option.first');
        $imageURL = $request->imageURL;

        $image = $imageURL ? view('clients.survey.elements.image-question', compact('imageURL'))->render() : '';

        return response()->json([
            'success' => true,
            'html' => view('clients.survey.elements.multiple-choice', compact(
                'sectionId',
                'questionId',
                'answerId',
                'optionId',
                'imageURL'
            ))->render(),
            'image' => $image,
        ]);
    }

    public function fetchCheckboxes(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $sectionId = $request->sectionId;
        $questionId = $request->questionId;
        $answerId = $request->answerId;
        $optionId = config('settings.survey.option.first');
        $imageURL = $request->imageURL;

        $image = $imageURL ? view('clients.survey.elements.image-question', compact('imageURL'))->render() : '';

        return response()->json([
            'success' => true,
            'html' => view('clients.survey.elements.checkboxes', compact(
                'sectionId',
                'questionId',
                'answerId',
                'optionId',
                'imageURL'
            ))->render(),
            'image' => $image,
        ]);
    }

    public function fetchDate(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $sectionId = $request->sectionId;
        $questionId = $request->questionId;
        $imageURL = $request->imageURL;

        $image = $imageURL ? view('clients.survey.elements.image-question', compact('imageURL'))->render() : '';

        return response()->json([
            'success' => true,
            'html' => view('clients.survey.elements.date', compact(
                'sectionId',
                'questionId',
                'imageURL'
            ))->render(),
            'image' => $image,
        ]);
    }

    public function fetchTime(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $sectionId = $request->sectionId;
        $questionId = $request->questionId;
        $imageURL = $request->imageURL;

        $image = $imageURL ? view('clients.survey.elements.image-question', compact('imageURL'))->render() : '';

        return response()->json([
            'success' => true,
            'html' => view('clients.survey.elements.time', compact(
                'sectionId',
                'questionId',
                'imageURL'
            ))->render(),
            'image' => $image,
        ]);
    }

    public function fetchImage(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $sectionId = $request->sectionId;
        $questionId = $request->questionId;
        $imageURL = $request->imageURL;

        return response()->json([
            'success' => true,
            'html' => view('clients.survey.elements.section-image', compact(
                'sectionId',
                'questionId',
                'imageURL'
            ))->render(),
        ]);
    }

    public function fetchVideo(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $sectionId = $request->sectionId;
        $questionId = $request->questionId;
        $thumbnailVideo = $request->thumbnailVideo;
        $urlEmbed = $request->urlEmbed;

        return response()->json([
            'success' => true,
            'html' => view('clients.survey.elements.section-video', compact(
                'sectionId',
                'questionId',
                'thumbnailVideo',
                'urlEmbed'
            ))->render(),
        ]);
    }

    public function fetchImageQuestion(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $imageURL = $request->imageURL;

        return response()->json([
            'success' => true,
            'html' => view('clients.survey.elements.image-question', compact('imageURL'))->render(),
            'imageURL' => $imageURL,
        ]);
    }

    public function fetchImageAnswer(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $imageURL = $request->imageURL;

        return response()->json([
            'success' => true,
            'html' => view('clients.survey.elements.image-answer', compact('imageURL'))->render(),
            'imageURL' => $imageURL,
        ]);
    }

    public function fetchRedirectQuestion(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $data = $request->only(
            'numberOfSections',
            'sectionId',
            'questionId',
            'redirectSectionData'
        );

        $data['optionId'] = config('settings.survey.option.first');

        return response()->json([
            'success' => true,
            'html' => view('clients.survey.elements.section-redirect-question')->with($data)->render(),
        ]);
    }
}
