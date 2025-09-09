<?php
namespace App\Repositories;
use App\Models\Account;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AccountRepository implements AccountRepositoryInterface{
    public function index(Request $request)
    {
        $query = Account::with('user');
        if($request->has('search') && !empty($request->search)){
            $query->where('username', 'LIKE', '%' . $request->search . '%');
        }
        $accounts = $query->paginate(8);
        return response()->json($accounts, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);
        DB::beginTransaction();
        try{
            $account = Account::create([
                'id' => $request->input('id'),
                'username' => $request->input('username'),
                'password'   => Hash::make($request->input('password')),
                'memo' => $request->input('memo'),
                'created_at' => now(),
                'role' => 'user'
            ]);
            DB::commit();
            return response()->json($account, 201);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }
}
