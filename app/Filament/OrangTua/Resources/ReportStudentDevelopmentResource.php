<?php

namespace App\Filament\OrangTua\Resources;

use App\Filament\OrangTua\Resources\ReportStudentDevelopmentResource\Pages;
use App\Filament\OrangTua\Resources\ReportStudentDevelopmentResource\RelationManagers;
use App\Models\ReportStudentDevelopment;
use App\Models\StudentDevelopment;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportStudentDevelopmentResource extends Resource
{
    protected static ?string $model = StudentDevelopment::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationLabel = 'Laporan Perkembangan Anak';
    protected static ?string $pluralLabel = 'Laporan Perkembangan Anak Anda';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('student', function (Builder $query) {
                $query->where('parent_id', \Illuminate\Support\Facades\Auth::id());
            });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
						->paginated(false)
            ->columns([
                TextColumn::make('student.name')
                    ->label('Nama Anak')
                    ,
                TextColumn::make('period')
                    ->label('Periode')
                    ->date('F Y')
                    ,
                TextColumn::make('score')
                    ->label('Nilai Rata-rata')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Berkembang' => 'success',
                        'Stimulan' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('pdf') 
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('danger')
                    ->action(function (Model $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadView('pdf.student_development_report', ['record' => $record])->stream();
                        }, 'laporan-perkembangan-' . $record->id . '.pdf');
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReportStudentDevelopments::route('/'),
            'create' => Pages\CreateReportStudentDevelopment::route('/create'),
            // 'edit' => Pages\EditReportStudentDevelopment::route('/{record}/edit'),
        ];
    }
}
