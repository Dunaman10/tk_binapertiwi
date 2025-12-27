<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\StudentDevelopmentResource\Pages;
use App\Filament\Guru\Resources\StudentDevelopmentResource\RelationManagers;
use App\Models\Student;
use App\Models\StudentDevelopment;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentDevelopmentResource extends Resource
{
    protected static ?string $model = StudentDevelopment::class;
    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';
    protected static ?string $navigationLabel = 'Data Perkembangan Anak';
    protected static ?string $pluralLabel = 'Data Perkembangan Anak';
    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('student.class', function (Builder $query) {
                $query->where('teacher_id', \Illuminate\Support\Facades\Auth::id());
            });
    }

    public static function form(Form $form): Form
    {
        return $form
						->columns(1)
            ->schema([
              Select::make('student_name')
								->label('Nama')
								->required()
								->preload()
								->searchable()
								->options(Student::whereHas('class', function ($query) {
                    $query->where('teacher_id', \Illuminate\Support\Facades\Auth::id());
                })->pluck('name', 'id')),

							TextInput::make('period')
							->label('Periode')
							->required()
							->type('month'),

							Textarea::make('notes')
							->label('Catatan')
							->placeholder('masukkan catatan'),

							Section::make('Aspek Nilai Perkembangan Anak')
							->description('Nilai mulai dari 0 - 100')
							->schema([
								TextInput::make('motorik')
									->label('Motorik')
									->required()
									->numeric()
									->maxValue(100)
									->live(onBlur: true)
									->afterStateUpdated(fn (Get $get, Set $set) => self::calculateResult($get, $set))
									->placeholder('masukkan motorik'),

								TextInput::make('kognitif')
									->label('Kognitif')
									->required()
									->numeric()
									->maxValue(100)
									->live(onBlur: true)
									->afterStateUpdated(fn (Get $get, Set $set) => self::calculateResult($get, $set))
									->placeholder('masukkan kognitif'),

								TextInput::make('bahasa')
									->label('Bahasa')
									->required()
									->numeric()
									->maxValue(100)
									->live(onBlur: true)
									->afterStateUpdated(fn (Get $get, Set $set) => self::calculateResult($get, $set))
									->placeholder('masukkan bahasa'),

								TextInput::make('sosial_emosional')
									->label('Sosial Emosional')
									->required()
									->numeric()
									->maxValue(100)
									->live(onBlur: true)
									->afterStateUpdated(fn (Get $get, Set $set) => self::calculateResult($get, $set))
									->placeholder('masukkan sosial emosional'),
							]),
                            
                TextInput::make('score')
								->label('Nilai Rata-rata')
								->readOnly(),
							
                TextInput::make('status')
								->label('Status')
								->readOnly(),
							
            ]);
    }

    public static function calculateResult(Get $get, Set $set): void
    {
        $motorik = (int) $get('motorik');
        $kognitif = (int) $get('kognitif');
        $bahasa = (int) $get('bahasa');
        $sosial_emosional = (int) $get('sosial_emosional');

        $average = ($motorik + $kognitif + $bahasa + $sosial_emosional) / 4;

        $set('score', number_format($average, 2));

        $status = match (true) {
            $average >= 80 => 'Baik',
            $average >= 70 => 'Cukup',
            default => 'Kurang',
        };

        $set('status', $status);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
								TextColumn::make('student.name')
								->label('Nama Anak')
								->searchable(),

								TextColumn::make('period')
								->label('Periode')
								->searchable()
								->date('M Y'),

								TextColumn::make('score')
								->label('Nilai Rata-Rata')
								->searchable(),

								TextColumn::make('status')
								->label('Status')
								->searchable()
								 ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Baik' => 'success',
                        'Cukup' => 'warning',
                        'Kurang' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
								->label('Lihat'),
                Tables\Actions\EditAction::make()
								->label('Ubah'),
                Tables\Actions\DeleteAction::make()
								->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListStudentDevelopments::route('/'),
            'create' => Pages\CreateStudentDevelopment::route('/create'),
            // 'edit' => Pages\EditStudentDevelopment::route('/{record}/edit'),
        ];
    }
}
