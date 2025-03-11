<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(public AuthRepository $authRepository) {
    }

    public function login(Request $request)
    {
        $user = $this->authRepository->check($request->all());
        
        if($user){
            Auth::login($user);
            session()->put('auth_token', $user->createToken('auth_token')->plainTextToken);
            return redirect()->route('home');
        }else{
            return redirect()->back();
        }
    }
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        Auth::login($user);
        return redirect()->route('home');
    }
}
