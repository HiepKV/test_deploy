<?php
namespace App\Http\Controllers;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $account;
    public function __construct(AccountService $account)
    {
        $this->account = $account;
    }
    public function index(Request $request)
    {
        return $this->account->index($request);
    }
    public function store(Request $request)
    {
        return $this->account->store($request);
    }

}
