<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentDevelopmentResource\Pages;
use App\Filament\Resources\StudentDevelopmentResource\RelationManagers;
use App\Models\Student;
use App\Models\StudentDevelopment;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
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
    protected static ?int $navigationSort = 4;

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
								->options(Student::all()->pluck('name', 'id')),

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
    public static function calculateResult(Get $get, Set $set): void
    {
        $motorik = (float) $get('motorik');
        $kognitif = (float) $get('kognitif');
        $bahasa = (float) $get('bahasa');
        $sosial_emosional = (float) $get('sosial_emosional');

        $avg = ($motorik + $kognitif + $bahasa + $sosial_emosional) / 4;
        $result = self::fuzzy_evaluate($avg);

        $set('score', number_format($avg, 2));
        $set('status', $result['label']);
    }

    public static function fuzzy_evaluate(float $score): array
    {
        $score = max(0, min(100, $score));

        // Fungsi keanggotaan segitiga sederhana
        $kurang = 0.0;
        if ($score <= 40) {
            $kurang = 1;
        } elseif ($score > 40 && $score < 60) {
            $kurang = (60 - $score) / 20;
        }

        $cukup = 0.0;
        if ($score >= 40 && $score <= 60) {
            $cukup = ($score - 40) / 20;
        } elseif ($score > 60 && $score < 80) {
            $cukup = (80 - $score) / 20;
        }

        $baik = 0.0;
        if ($score >= 60 && $score <= 80) {
            $baik = ($score - 60) / 20;
        } elseif ($score > 80) {
            $baik = 1;
        }

        $memberships = [
            'Kurang' => round($kurang, 2),
            'Cukup'  => round($cukup, 2),
            'Baik'   => round($baik, 2),
        ];

        // Ambil label dengan derajat terbesar
        $label = array_keys($memberships, max($memberships))[0];

        return [
            'label' => $label,
            'memberships' => $memberships,
        ];
    }
}
