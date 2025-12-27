<?php

namespace App\Filament\Guru\Resources\StudentDevelopmentResource\Pages;

use App\Filament\Guru\Resources\StudentDevelopmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentDevelopments extends ListRecords
{
    protected static string $resource = StudentDevelopmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Tambah Data Perkembangan Anak'),
        ];
    }
}
