<?php
namespace App\Http\Controllers;
use App\Services\SurveyService;
use Illuminate\Http\Request;
class SurveyController
{
    protected $survey;
    public function __construct(SurveyService $survey)
    {
        $this->survey = $survey;
    }
    public function index(Request $request)
    {
        $surveys = $this->survey->index($request);
        return response()->json($surveys, 200);
    }

    public function getById($id)
    {
        $survey = $this->survey->getById($id);
        return response()->json($survey, 200);
    }
    public function store(Request $request)
    {
        $survey = $this->survey->store($request);
        return response()->json($survey, 200);
    }
}
