<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Manager;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    // Get list of companies
    public function index(Request $request)
    {
        $query = Company::with('manager');

        // Nếu có từ khóa tìm kiếm, áp dụng bộ lọc
        if ($request->has('search') && !empty($request->search)) {
            $query->where('company_name', 'LIKE', '%' . $request->search . '%');
        }

        $companies = $query->paginate(8);
        return response()->json($companies);
    }

    // Create a new company with manager
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'company_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'company_created_by' => 'required|string',
            'manager_name' => 'required|string|max:255',
            'gender' => 'required|string|max:100',
            'reason' => 'nullable|string',
            'niece' => 'nullable|string',
        ]);

        // Use transaction to ensure data consistency
        DB::beginTransaction();

        try {
            // Create manager first
            $manager = Manager::create([
                'manager_name' => $request->input('manager_name'),
                'gender' => $request->input('gender'),
                'reason' => $request->input('reason'),
                'niece' => $request->input('niece'),
            ]);

            // Create company with manager_id
            $company = Company::create([
                'company_name' => $request->input('company_name'),
                'manager_id' => $manager->id,
                'phone_number' => $request->input('phone_number'),
                'email' => $request->input('email'),
                'company_created_by' => $request->input('company_created_by'),
            ]);

            // Commit transaction
            DB::commit();

            return response()->json([
                'message' => 'Company and Manager created successfully',
                'company' => $company,
                'manager' => $manager,
            ], 201);
        } catch (\Exception $e) {
            // Rollback transaction if any error occurs
            DB::rollBack();

            return response()->json([
                'message' => 'Error occurred while creating company and manager',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Get single company
    public function show($id)
    {
        $company = Company::with('manager')->findOrFail($id);
        return response()->json($company);
    }

    // Update company
    // public function update(Request $request, $id)
    // {
    //     $company = Company::findOrFail($id);

    //     $request->validate([
    //         'company_name' => 'string|max:255',
    //         'manager_id' => 'exists:managers,id',
    //         'phone_number' => 'string|max:20',
    //         'email' => 'email|max:255',
    //         'company_created_by' => 'string',
    //     ]);

    //     $company->update($request->all());
    //     return response()->json(['message' => 'Company updated successfully', 'data' => $company]);
    // }

    // Delete company
    // public function destroy($id)
    // {
    //     $company = Company::findOrFail($id);
    //     $company->delete();
    //     return response()->json(['message' => 'Company deleted successfully']);
    // }
}
