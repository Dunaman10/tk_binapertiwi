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
        $motorik = (float) $get('motorik');
        $kognitif = (float) $get('kognitif');
        $bahasa = (float) $get('bahasa');
        $sosial_emosional = (float) $get('sosial_emosional');

        $result = self::mamdani_evaluate($motorik, $kognitif, $bahasa, $sosial_emosional);

        $set('score', number_format($result['score'], 2));
        $set('status', $result['label']);
    }

    public static function mamdani_evaluate(float $motorik, float $kognitif, float $bahasa, float $sosial): array
    {
        // 1. Fuzzification
        $inputs = [$motorik, $kognitif, $bahasa, $sosial];
        $sets = ['Kurang', 'Cukup', 'Baik'];
        $fuzzyInputs = [];

        foreach ($inputs as $val) {
            $fuzzyInputs[] = [
                'Kurang' => self::membershipKurang($val),
                'Cukup'  => self::membershipCukup($val),
                'Baik'   => self::membershipBaik($val),
            ];
        }

        // 2. Rule Evaluation
        $degrees = ['Kurang' => 0.0, 'Cukup' => 0.0, 'Baik' => 0.0];

        // Iterate all 3^4 = 81 rules
        // i, j, k, l maintain indices for Motorik, Kognitif, Bahasa, Sosial
        for ($i=0; $i<3; $i++) {
            for ($j=0; $j<3; $j++) {
                for ($k=0; $k<3; $k++) {
                    for ($l=0; $l<3; $l++) {
                        
                        // Antecedent Activation (Min operator)
                        $alpha = min(
                            $fuzzyInputs[0][$sets[$i]],
                            $fuzzyInputs[1][$sets[$j]],
                            $fuzzyInputs[2][$sets[$k]],
                            $fuzzyInputs[3][$sets[$l]]
                        );

                        if ($alpha > 0) {
                            $sumIndices = $i + $j + $k + $l;
                            
                            // Rule Base Logic based on Average Index Strength
                            // Indices: 0=Kurang, 1=Cukup, 2=Baik
                            // Sum Range: 0 to 8
                            if ($sumIndices <= 2) {
                                $consequent = 'Kurang';
                            } elseif ($sumIndices <= 5) {
                                $consequent = 'Cukup';
                            } else {
                                $consequent = 'Baik';
                            }

                            // Aggregation (Max operator)
                            $degrees[$consequent] = max($degrees[$consequent], $alpha);
                        }
                    }
                }
            }
        }

        // 3. Defuzzification (Centroid Method)
        $numerator = 0.0;
        $denominator = 0.0;
        $step = 5; // Sampling step size

        for ($x = 0; $x <= 100; $x += $step) {
            $mu_K = self::membershipKurang($x);
            $mu_C = self::membershipCukup($x);
            $mu_B = self::membershipBaik($x);

            // Clip membership by rule strength
            $val_K = min($mu_K, $degrees['Kurang']);
            $val_C = min($mu_C, $degrees['Cukup']);
            $val_B = min($mu_B, $degrees['Baik']);

            // Aggregate Output
            $mu_agg = max($val_K, $val_C, $val_B);

            $numerator += $x * $mu_agg;
            $denominator += $mu_agg;
        }

        $finalScore = $denominator > 0 ? $numerator / $denominator : 0;

        // Final Label Determination
        $finalLabel = 'Kurang';
        if ($finalScore >= 50) $finalLabel = 'Cukup';
        if ($finalScore >= 75) $finalLabel = 'Baik';

        return [
            'score' => $finalScore,
            'label' => $finalLabel,
        ];
    }

    private static function membershipKurang(float $x): float
    {
        if ($x <= 40) return 1.0;
        if ($x >= 60) return 0.0;
        return (60 - $x) / 20;
    }

    private static function membershipCukup(float $x): float
    {
        if ($x <= 40 || $x >= 80) return 0.0;
        if ($x <= 60) return ($x - 40) / 20;
        return (80 - $x) / 20;
    }

    private static function membershipBaik(float $x): float
    {
        if ($x <= 60) return 0.0;
        if ($x >= 80) return 1.0;
        return ($x - 60) / 20;
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
