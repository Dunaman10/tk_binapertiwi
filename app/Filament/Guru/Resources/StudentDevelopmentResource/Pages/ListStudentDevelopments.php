<?php

namespace App\Filament\Guru\Resources\StudentDevelopmentResource\Pages;

use App\Filament\Guru\Resources\StudentDevelopmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListStudentDevelopments extends ListRecords
{
    protected static string $resource = StudentDevelopmentResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [];

        if (Auth::user()->is_responsible) {
            $actions[] = Actions\CreateAction::make()
                ->label('Tambah Data Perkembangan Anak');
        }

        return $actions;
    }
}
