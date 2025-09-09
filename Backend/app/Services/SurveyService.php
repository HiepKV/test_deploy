<?php
namespace App\Services;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use Illuminate\Http\Request;

class SurveyService
{
    protected $survey;
    public function __construct(SurveyRepositoryInterface $survey)
    {
        $this->survey = $survey;
    }
    public function index(Request $request)
    {
        return $this->survey->index($request);
    }
    public function getById(int $id)
    {
        return $this->survey->show($id);
    }
    public function store(Request $request)
    {
        return $this->survey->store($request);
    }
}
