<?php
namespace App\Services;
use App\Models\Account;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Illuminate\Http\Request;

class AccountService
{
    protected $account;
    public function __construct(AccountRepositoryInterface $account)
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
