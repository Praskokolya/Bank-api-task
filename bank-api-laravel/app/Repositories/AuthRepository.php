<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class AuthRepository
{
    public function __construct(public User $user) {}
    
    public function check(array $data)
    {
        $user = $this->user->where('email', $data['email'])->first();
        if($user && Hash::check($data['password'], $user->password)) {
            return $user;
        }
    }
}
