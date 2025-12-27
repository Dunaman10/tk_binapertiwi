<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user->role === 'guru') {
            return redirect()->to('/guru');
        }

        if ($user->role === 'orang_tua') {
            return redirect()->to('/orang_tua');
        }

        return redirect()->to('/auth');
    }
}
