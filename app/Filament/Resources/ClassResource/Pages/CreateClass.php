<?php

namespace App\Filament\Resources\ClassResource\Pages;

use App\Filament\Resources\ClassResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClass extends CreateRecord
{
    protected static string $resource = ClassResource::class;

     public function getTitle(): string
    {
        return 'Tambah Data Kelas';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah Data Kelas';
    }
}
