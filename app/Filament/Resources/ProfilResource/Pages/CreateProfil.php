<?php

namespace App\Filament\Resources\ProfilResource\Pages;

use App\Filament\Resources\ProfilResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProfil extends CreateRecord
{
  protected static string $resource = ProfilResource::class;

  public function getTitle(): string
  {
    return 'Buat Profil TK Bina Pertiwi';
  }
}
