<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;

class ManagerController extends Controller
{
    // // Get list of managers
    // public function index()
    // {
    //     $managers = Manager::all();
    //     return response()->json($managers);
    // }

    // // Create a new manager
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'manager_name' => 'required|string|max:255',
    //         'gender' => 'required|boolean',
    //         'reason' => 'string|nullable',
    //         'niece' => 'string|nullable',
    //     ]);

    //     $manager = Manager::create($request->all());
    //     return response()->json(['message' => 'Manager created successfully', 'data' => $manager]);
    // }
}
