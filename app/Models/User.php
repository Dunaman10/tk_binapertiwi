<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'email',
    'role',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function canAccessPanel(\Filament\Panel $panel): bool
  {
      if ($panel->getId() === 'auth') {
          return in_array($this->role, ['admin', 'guru', 'orang_tua']);
      }

      if ($panel->getId() === 'guru') {
          return $this->role === 'guru';
      }

      if ($panel->getId() === 'orang_tua') {
          return $this->role === 'orang_tua';
      }

      return false;
  }
}
