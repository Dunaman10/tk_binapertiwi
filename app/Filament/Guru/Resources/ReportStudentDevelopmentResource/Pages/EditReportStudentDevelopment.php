<?php

namespace App\Filament\Guru\Resources\ReportStudentDevelopmentResource\Pages;

use App\Filament\Guru\Resources\ReportStudentDevelopmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportStudentDevelopment extends EditRecord
{
    protected static string $resource = ReportStudentDevelopmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
