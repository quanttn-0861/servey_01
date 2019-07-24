<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Survey\SurveyInterface;
use Exception, Auth, Datatables, Session, DB, Storage;

class ListSurveyController extends Controller
{
    protected $surveyRepository;

    public function __construct(SurveyInterface $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($data = [])
    {
        try {
            $user = Auth::user();
            $surveys = $this->surveyRepository->getAllSurvey($data);

            return view('clients.profile.list-survey', compact('user', 'surveys'));
        } catch (Exception $e) {

            return view('clients.layout.404');
        }
    }
}
