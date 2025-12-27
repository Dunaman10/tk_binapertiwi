<?php

namespace App\Filament\Resources\ArchiveResource\Pages;

use App\Filament\Resources\ArchiveResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArchive extends CreateRecord
{
    protected static string $resource = ArchiveResource::class;

    public function getTitle(): string
    {
        return 'Tambah Arsip';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah Arsip';
    }
}
