<?php

namespace App\Filament\Resources\ReportStudentDevelopmentResource\Pages;

use App\Filament\Resources\ReportStudentDevelopmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportStudentDevelopments extends ListRecords
{
    protected static string $resource = ReportStudentDevelopmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->hidden(),
        ];
    }
}
