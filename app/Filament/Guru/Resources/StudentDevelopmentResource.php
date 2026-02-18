<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\StudentDevelopmentResource\Pages;
use App\Models\Student;
use App\Models\StudentDevelopment;
use Filament\Forms\Components\Placeholder;
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
use Illuminate\Support\HtmlString;

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
                    ->minValue(0)
                    ->maxValue(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Get $get, Set $set) => self::calculateResult($get, $set))
                    ->placeholder('masukkan motorik'),

                  Placeholder::make('motorik_label')
                    ->label('')
                    ->content(function (Get $get): HtmlString {
                      $val = (float) $get('motorik');
                      if ($val <= 0) return new HtmlString('');
                      $label = self::getMotorikLabel($val);
                      $color = self::getLabelColor($label);
                      return new HtmlString("<span style='font-weight:600; color:{$color}; font-size:0.875rem;'>Kategori Motorik: {$label}</span>");
                    }),

                  TextInput::make('kognitif')
                    ->label('Kognitif')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Get $get, Set $set) => self::calculateResult($get, $set))
                    ->placeholder('masukkan kognitif'),

                  Placeholder::make('kognitif_label')
                    ->label('')
                    ->content(function (Get $get): HtmlString {
                      $val = (float) $get('kognitif');
                      if ($val <= 0) return new HtmlString('');
                      $label = self::getKognitifLabel($val);
                      $color = self::getLabelColor($label);
                      return new HtmlString("<span style='font-weight:600; color:{$color}; font-size:0.875rem;'>Kategori Kognitif: {$label}</span>");
                    }),

                  TextInput::make('bahasa')
                    ->label('Bahasa')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Get $get, Set $set) => self::calculateResult($get, $set))
                    ->placeholder('masukkan bahasa'),

                  Placeholder::make('bahasa_label')
                    ->label('')
                    ->content(function (Get $get): HtmlString {
                      $val = (float) $get('bahasa');
                      if ($val <= 0) return new HtmlString('');
                      $label = self::getBahasaLabel($val);
                      $color = self::getLabelColor($label);
                      return new HtmlString("<span style='font-weight:600; color:{$color}; font-size:0.875rem;'>Kategori Bahasa: {$label}</span>");
                    }),

                  TextInput::make('sosial_emosional')
                    ->label('Sosial Emosional')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Get $get, Set $set) => self::calculateResult($get, $set))
                    ->placeholder('masukkan sosial emosional'),

                  Placeholder::make('sosial_emosional_label')
                    ->label('')
                    ->content(function (Get $get): HtmlString {
                      $val = (float) $get('sosial_emosional');
                      if ($val <= 0) return new HtmlString('');
                      $label = self::getSosialEmosionalLabel($val);
                      $color = self::getLabelColor($label);
                      return new HtmlString("<span style='font-weight:600; color:{$color}; font-size:0.875rem;'>Kategori Sosial Emosional: {$label}</span>");
                    }),
                ]),

              TextInput::make('score')
                ->label('Nilai Rata-rata')
                ->readOnly(),

              TextInput::make('status')
                ->label('Hasil (Status)')
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

                TextColumn::make('motorik')
                  ->label('Motorik')
                  ->searchable(),

                TextColumn::make('kognitif')
                  ->label('Kognitif')
                  ->searchable(),

                TextColumn::make('bahasa')
                  ->label('Bahasa')
                  ->searchable(),

                TextColumn::make('sosial_emosional')
                  ->label('Sosial Emosional')
                  ->searchable(),

                TextColumn::make('score')
                  ->label('Nilai Rata-rata')
                  ->searchable(),

                TextColumn::make('status')
                  ->label('Hasil')
                  ->searchable()
                  ->badge()
                  ->color(fn(string $state): string => match ($state) {
                    'Berkembang' => 'success',
                    'Stimulan' => 'warning',
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

    // ===================================================================
    // Label helpers for displaying category based on crisp input value
    // ===================================================================

    public static function getMotorikLabel(float $val): string
    {
        if ($val > 75) return 'Baik';
        if ($val > 50) return 'Cukup';
        return 'Kurang';
    }

    public static function getKognitifLabel(float $val): string
    {
        if ($val > 75) return 'Tinggi';
        if ($val > 50) return 'Sedang';
        return 'Rendah';
    }

    public static function getBahasaLabel(float $val): string
    {
        if ($val > 60) return 'Tercapai';
        return 'Sedang Berproses';
    }

    public static function getSosialEmosionalLabel(float $val): string
    {
        if ($val > 60) return 'Sangat Baik';
        if ($val > 45) return 'Baik';
        return 'Butuh Bimbingan';
    }

    private static function getLabelColor(string $label): string
    {
        if (in_array($label, ['Baik', 'Tinggi', 'Tercapai', 'Sangat Baik'])) {
            return '#16a34a';
        }
        if (in_array($label, ['Kurang', 'Rendah', 'Butuh Bimbingan'])) {
            return '#dc2626';
        }
        return '#d97706';
    }

    // ===================================================================
    // FUZZY LOGIC - Mamdani Method
    // ===================================================================

    public static function calculateResult(Get $get, Set $set): void
    {
        $motorik = (float) $get('motorik');
        $kognitif = (float) $get('kognitif');
        $bahasa = (float) $get('bahasa');
        $sosial_emosional = (float) $get('sosial_emosional');

        if ($motorik <= 0 && $kognitif <= 0 && $bahasa <= 0 && $sosial_emosional <= 0) {
            $set('score', '');
            $set('status', '');
            return;
        }

        $result = self::fuzzyMamdani($motorik, $kognitif, $bahasa, $sosial_emosional);

        $set('score', number_format($result['score'], 2));
        $set('status', $result['label']);
    }

    public static function fuzzyMamdani(float $motorik, float $kognitif, float $bahasa, float $sosial): array
    {
        // STEP 1: FUZZIFICATION
        $mMotorik = [
            'kurang' => self::motorikKurang($motorik),
            'cukup'  => self::motorikCukup($motorik),
            'baik'   => self::motorikBaik($motorik),
        ];
        $mKognitif = [
            'rendah' => self::kognitifRendah($kognitif),
            'sedang' => self::kognitifSedang($kognitif),
            'tinggi' => self::kognitifTinggi($kognitif),
        ];
        $mBahasa = [
            'sedang_berproses' => self::bahasaSedangBerproses($bahasa),
            'tercapai'         => self::bahasaTercapai($bahasa),
        ];
        $mSosial = [
            'butuh_bimbingan' => self::sosialButuhBimbingan($sosial),
            'baik'            => self::sosialBaik($sosial),
            'sangat_baik'     => self::sosialSangatBaik($sosial),
        ];

        // STEP 2: RULE EVALUATION (54 Rules)
        $rules = self::getFuzzyRules();
        $alphaStimulasi = 0.0;
        $alphaBerkembang = 0.0;

        foreach ($rules as $rule) {
            $alpha = min(
                $mMotorik[$rule['motorik']],
                $mKognitif[$rule['kognitif']],
                $mBahasa[$rule['bahasa']],
                $mSosial[$rule['sosial']],
            );
            if ($rule['output'] === 'stimulasi') {
                $alphaStimulasi = max($alphaStimulasi, $alpha);
            } else {
                $alphaBerkembang = max($alphaBerkembang, $alpha);
            }
        }

        // STEP 3 & 4: DEFUZZIFICATION (Centroid)
        $numerator = 0.0;
        $denominator = 0.0;
        $step = 0.5;

        for ($z = 0; $z <= 100; $z += $step) {
            $muStimulasi = min(self::outputStimulasi($z), $alphaStimulasi);
            $muBerkembang = min(self::outputBerkembang($z), $alphaBerkembang);
            $muAgg = max($muStimulasi, $muBerkembang);
            $numerator += $z * $muAgg;
            $denominator += $muAgg;
        }

        $finalScore = $denominator > 0 ? $numerator / $denominator : 0;
        $finalLabel = $finalScore > 50 ? 'Berkembang' : 'Stimulan';

        return ['score' => $finalScore, 'label' => $finalLabel];
    }

    // MEMBERSHIP FUNCTIONS - MOTORIK (boundaries: 40, 60, 80)
    private static function motorikKurang(float $x): float
    {
        if ($x <= 40) return 1.0;
        if ($x >= 60) return 0.0;
        return (60 - $x) / 20;
    }

    private static function motorikCukup(float $x): float
    {
        if ($x <= 40 || $x >= 80) return 0.0;
        if ($x < 60) return ($x - 40) / 20;
        return (80 - $x) / 20;
    }

    private static function motorikBaik(float $x): float
    {
        if ($x <= 60) return 0.0;
        if ($x >= 80) return 1.0;
        return ($x - 60) / 20;
    }

    // MEMBERSHIP FUNCTIONS - KOGNITIF (boundaries: 40, 60, 80)
    private static function kognitifRendah(float $x): float
    {
        if ($x <= 40) return 1.0;
        if ($x >= 60) return 0.0;
        return (60 - $x) / 20;
    }

    private static function kognitifSedang(float $x): float
    {
        if ($x <= 40 || $x >= 80) return 0.0;
        if ($x < 60) return ($x - 40) / 20;
        return (80 - $x) / 20;
    }

    private static function kognitifTinggi(float $x): float
    {
        if ($x <= 60) return 0.0;
        if ($x >= 80) return 1.0;
        return ($x - 60) / 20;
    }

    // MEMBERSHIP FUNCTIONS - BAHASA (boundaries: 40, 80)
    private static function bahasaSedangBerproses(float $x): float
    {
        if ($x <= 40) return 1.0;
        if ($x >= 80) return 0.0;
        return (80 - $x) / 40;
    }

    private static function bahasaTercapai(float $x): float
    {
        if ($x <= 40) return 0.0;
        if ($x >= 80) return 1.0;
        return ($x - 40) / 40;
    }

    // MEMBERSHIP FUNCTIONS - SOSIAL EMOSIONAL (boundaries: 40, 50, 60)
    private static function sosialButuhBimbingan(float $x): float
    {
        if ($x <= 40) return 1.0;
        if ($x >= 50) return 0.0;
        return (50 - $x) / 10;
    }

    private static function sosialBaik(float $x): float
    {
        if ($x <= 40 || $x >= 60) return 0.0;
        if ($x < 50) return ($x - 40) / 10;
        return (60 - $x) / 10;
    }

    private static function sosialSangatBaik(float $x): float
    {
        if ($x <= 50) return 0.0;
        if ($x >= 60) return 1.0;
        return ($x - 50) / 10;
    }

    // MEMBERSHIP FUNCTIONS - OUTPUT (boundaries: 50, 70)
    private static function outputStimulasi(float $z): float
    {
        if ($z <= 50) return 1.0;
        if ($z >= 70) return 0.0;
        return (70 - $z) / 20;
    }

    private static function outputBerkembang(float $z): float
    {
        if ($z <= 50) return 0.0;
        if ($z >= 70) return 1.0;
        return ($z - 50) / 20;
    }

    // FUZZY RULES - All 54 Combinations (3×3×2×3)
    private static function getFuzzyRules(): array
    {
        $motorikLevels  = ['kurang', 'cukup', 'baik'];
        $kognitifLevels = ['rendah', 'sedang', 'tinggi'];
        $bahasaLevels   = ['sedang_berproses', 'tercapai'];
        $sosialLevels   = ['butuh_bimbingan', 'baik', 'sangat_baik'];

        $motorikScores  = ['kurang' => -2, 'cukup' => 0, 'baik' => 1];
        $kognitifScores = ['rendah' => -2, 'sedang' => 0, 'tinggi' => 1];
        $bahasaScores   = ['sedang_berproses' => -1, 'tercapai' => 1];
        $sosialScores   = ['butuh_bimbingan' => -2, 'baik' => 0, 'sangat_baik' => 1];

        $rules = [];
        foreach ($motorikLevels as $m) {
            foreach ($kognitifLevels as $k) {
                foreach ($bahasaLevels as $b) {
                    foreach ($sosialLevels as $s) {
                        $score = $motorikScores[$m] + $kognitifScores[$k] + $bahasaScores[$b] + $sosialScores[$s];
                        $rules[] = [
                            'motorik' => $m, 'kognitif' => $k, 'bahasa' => $b,
                            'sosial' => $s, 'output' => $score >= 0 ? 'berkembang' : 'stimulasi',
                        ];
                    }
                }
            }
        }
        return $rules;
    }
}
