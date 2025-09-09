<?php

namespace App\Repositories;

use App\Models\Intent;
use App\Models\Answer;
use App\Repositories\Contracts\InforRecipientRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InforRecipientRepository implements InforRecipientRepositoryInterface
{
    public function getInforRecipient($id)
    {
        $query = Intent::with('answers')->findOrFail($id);
        return response()->json($query, 201);
    }

    public function storeInforRecipient(Request $request)
    {
        $request->validate([
            'intent_name' => 'required|string',
            'survey_id'   => 'required|integer',
            'examples'    => 'nullable|string',
            'response_text' => 'required|string',
            'company_name'  => 'required|string',
            'phone_number'  => 'required|string',
            'email'         => 'required|email',
        ]);

        return DB::transaction(function () use ($request) {
            $intent = Intent::create([
                'intent_name' => $request->intent_name,
                'examples'    => $request->examples,
                'survey_id'   => $request->survey_id,
            ]);

            $answer = Answer::create([
                'intent_id'    => $intent->id,
                'response_text'=> $request->response_text,
                'company_name' => $request->company_name,
                'phone_number' => $request->phone_number,
                'email'        => $request->email,
            ]);

            return response()->json([
                'message' => 'Data stored successfully',
                'intent'  => $intent,
                'answer'  => $answer
            ], 201);
        });
    }
}
