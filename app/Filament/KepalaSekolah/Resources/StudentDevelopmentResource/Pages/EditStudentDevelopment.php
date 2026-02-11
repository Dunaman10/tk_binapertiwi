<?php

namespace App\Filament\KepalaSekolah\Resources\StudentDevelopmentResource\Pages;

use App\Filament\KepalaSekolah\Resources\StudentDevelopmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentDevelopment extends EditRecord
{
    protected static string $resource = StudentDevelopmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
