<?php
namespace App\Repositories\Contracts;
use Illuminate\Http\Request;
interface SurveyRepositoryInterface
{
    public function index(Request $request);
    public function store(Request $request);
    public function show($id);
}
