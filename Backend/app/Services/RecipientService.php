<?php
namespace App\Services;
use App\Repositories\Contracts\InforRecipientRepositoryInterface;
use Illuminate\Http\Request;
class RecipientService
{
    protected $recipient;
    public function __construct(InforRecipientRepositoryInterface $recipient)
    {
        $this->recipient = $recipient;
    }
    public function getRecipientById($id){
        return $this->recipient->getInforRecipient($id);
    }
    public function store(Request $request){
        return $this->recipient->storeInforRecipient($request);
    }
}
