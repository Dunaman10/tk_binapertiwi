<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectToCorrectPanel
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (Auth::check()) {
      $user = Auth::user();
      $currentPanelId = \Filament\Facades\Filament::getCurrentPanel()->getId();

      if ($currentPanelId === 'auth') {
        if ($user->role === 'guru') {
          return redirect()->to('/guru');
        }
        if ($user->role === 'orang_tua') {
          return redirect()->to('/orang_tua');
        }
        if ($user->role === 'kepala_sekolah') {
          return redirect()->to('/kepala_sekolah');
        }
      }
    }

    return $next($request);
  }
}
