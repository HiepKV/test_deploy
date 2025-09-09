<?php

namespace App\Repositories;

use App\Models\Survey;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ImageService;

class SurveyRepository implements SurveyRepositoryInterface
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $query = Survey::with('company')->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $query->where('survey_title', 'LIKE', '%' . $request->search . '%');
        }

        return $query->paginate(10);
    }

    public function store(Request $request)
    {
        $request->validate([
            'survey_title'   => 'required|string|max:255',
            'description'    => 'required|string',
            'survey_content' => 'required|string',
            'company_id'     => 'required|exists:companies,id',
            'status'         => 'nullable|string',
            'keyword'        => 'nullable|string',
            'prefectures'    => 'nullable|string',
            'hero_image'     => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date',
            'response_count' => 'nullable|integer',
            'sent_count'     => 'nullable|integer'
        ]);

        DB::beginTransaction();

        try {
            $heroImagePath = $this->imageService->upload(
                $request->file('hero_image'),
                'surveys'
            );

            $survey = Survey::create([
                'survey_title'   => $request->survey_title,
                'description'    => $request->description,
                'survey_content' => $request->survey_content,
                'company_id'     => $request->company_id,
                'user_id'        => $request->user_id ?? 1,
                'status'         => $request->status ?? 'waiting',
                'keyword'        => $request->keyword ?? null,
                'prefectures'    => $request->prefectures ?? null,
                'hero_image'     => $heroImagePath,
                'start_date'     => $request->start_date ?? null,
                'end_date'       => $request->end_date ?? null,
                'response_count' => $request->response_count ?? 0,
                'sent_count'     => $request->sent_count ?? 0,
            ]);

            DB::commit();

            return response()->json($survey, 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $survey = Survey::with('company', 'company.manager')
            ->withCount('intents')
            ->findOrFail($id);
        $survey->increment('response_count');
        return $survey;
    }
}
