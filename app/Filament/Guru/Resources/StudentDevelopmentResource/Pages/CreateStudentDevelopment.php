<?php

namespace App\Filament\Guru\Resources\StudentDevelopmentResource\Pages;

use App\Filament\Guru\Resources\StudentDevelopmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentDevelopment extends CreateRecord
{
    protected static string $resource = StudentDevelopmentResource::class;

    public function getTitle(): string
    {
        return 'Tambah Data Perkembangan Anak';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah Data Perkembangan Anak';
    }
}
