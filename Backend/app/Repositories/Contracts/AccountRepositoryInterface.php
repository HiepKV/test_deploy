<?php
namespace App\Repositories\Contracts;
use Illuminate\Http\Request;
interface AccountRepositoryInterface
{
    public function index(Request $request);
    public function store(Request $request);
}
