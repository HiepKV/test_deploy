<?php
namespace App\Repositories\Contracts;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

interface InforRecipientRepositoryInterface
{
    public function getInforRecipient($id);
    public function storeInforRecipient(Request $request);
}
