<?php

namespace App\Http\Controllers;

use App\Repositories\AccountRepository;
use App\Services\AccountService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __construct(public AccountRepository $accountRepository) {}
    
    public function create($currency)
    {
        try {
            $this->accountRepository->create($currency, Auth::user());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
        return 200;
    }

    public function index()
    {
        return Auth::user()->load('accounts');
    }

    public function transfer(Request $request){
        $this->accountRepository->transfer($request->all(), Auth::user());
    }
}
