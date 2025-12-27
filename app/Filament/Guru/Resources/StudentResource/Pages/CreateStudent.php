<?php

namespace App\Filament\Guru\Resources\StudentResource\Pages;

use App\Filament\Guru\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    public function getTitle(): string
    {
        return 'Tambah Data Anak';
    }

    public function getBreadcrumb(): string
    {
    return 'Tambah Data Anak';
  }
}
