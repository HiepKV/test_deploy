<?php
namespace App\Http\Controllers;
use App\Services\RecipientService;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    protected $recipient;
    public function __construct(RecipientService $recipient)
    {
        $this->recipient = $recipient;
    }
    public function getRecipientById($id){
        return $this->recipient->getRecipientById($id);
    }
    public function store(Request $request){
        return $this->recipient->store($request);
    }
}
