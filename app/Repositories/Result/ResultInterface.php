<?php

namespace App\Repositories\Result;

interface ResultInterface
{
    public function create($answers);

    public function storeResult($data, $survey);

    public function getDetailResultSurvey($request, $survey, $userRepo);

    public function closeFromSurvey($survey);

    public function openFromSurvey($survey);

    public function deleteFromSurvey($survey);

    public function getResultFromToken($token, $sections);

    public function getNewResults($data, $currentResult);

    public function updateNewResults($newResultsData, $currentResults, $survey);

    public function getResultByDate($data);
}
