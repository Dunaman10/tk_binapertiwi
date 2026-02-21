<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentDevelopmentResource\Pages;
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
use Illuminate\Support\HtmlString;

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

            TextInput::make('psikomotorik')
              ->label('Psikomotorik')
              ->required()
              ->numeric()
              ->minValue(0)
              ->maxValue(100)
              ->live(onBlur: true)
              ->afterStateUpdated(fn(Get $get, Set $set) => self::calculateResult($get, $set))
              ->placeholder('masukkan psikomotorik'),

            Placeholder::make('psikomotorik_label')
              ->label('')
              ->content(function (Get $get): HtmlString {
                $val = (float) $get('psikomotorik');
                if ($val <= 0) return new HtmlString('');
                $label = self::getPsikomotorikLabel($val);
                $color = self::getLabelColor($label);
                return new HtmlString("<span style='font-weight:600; color:{$color}; font-size:0.875rem;'>Kategori Psikomotorik: {$label}</span>");
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
          ->label('Nilai Rata-rata') // Nilai rata-rata adalah nilai hasil deffuzifikasi
          // ->hidden()
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

        TextColumn::make('kognitif')
          ->label('Kognitif')
          ->searchable(),

        TextColumn::make('psikomotorik')
          ->label('Psikomotorik')
          ->searchable(),

        TextColumn::make('sosial_emosional')
          ->label('Sosial Emosional')
          ->searchable(),

        TextColumn::make('score')
          ->label('Nilai Rata-rata') // Nilai rata-rata adalah nilai hasil deffuzifikasi
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

  /**
   * Kognitif: Tinggi (>75–≤100), Sedang (>50–<75), Rendah (0–<50)
   */
  public static function getKognitifLabel(float $val): string
  {
    if ($val > 75) return 'Tinggi';
    if ($val > 50) return 'Sedang';
    return 'Rendah';
  }

  /**
   * Psikomotorik: Terampil (>60–≤100), Belum Terampil (0–<60)
   */
  public static function getPsikomotorikLabel(float $val): string
  {
    if ($val > 60) return 'Terampil';
    return 'Belum Terampil';
  }

  /**
   * Sosial Emosional: Sangat Baik (>60–≤100), Baik (>45–<60), Butuh Bimbingan (0–<45)
   */
  public static function getSosialEmosionalLabel(float $val): string
  {
    if ($val > 60) return 'Sangat Baik';
    if ($val > 45) return 'Baik';
    return 'Butuh Bimbingan';
  }

  /**
   * Get color for label display
   */
  private static function getLabelColor(string $label): string
  {
    // Green - best tier labels
    if (in_array($label, ['Tinggi', 'Terampil', 'Sangat Baik'])) {
      return '#16a34a';
    }
    // Red - lowest tier labels
    if (in_array($label, ['Rendah', 'Butuh Bimbingan',])) {
      return '#dc2626';
    }
    // Amber - middle tier labels (Sedang, Baik, Belum Terampil)
    return '#d97706';
  }

  // ===================================================================
  // FUZZY LOGIC - Mamdani Method
  // ===================================================================

  public static function calculateResult(Get $get, Set $set): void
  {
    $kognitif = (float) $get('kognitif');
    $psikomotorik = (float) $get('psikomotorik');
    $sosial_emosional = (float) $get('sosial_emosional');

    // Only calculate if all inputs are provided
    if ($kognitif <= 0 && $psikomotorik <= 0 && $sosial_emosional <= 0) {
      $set('score', '');
      $set('status', '');
      return;
    }

    $result = self::fuzzyMamdani($kognitif, $psikomotorik, $sosial_emosional);

    $set('score', number_format($result['score'], 2));
    $set('status', $result['label']);
  }

  /**
   * Main Mamdani Fuzzy Logic evaluation
   * Steps: 1. Fuzzification → 2. Rule Evaluation → 3. Aggregation → 4. Defuzzification
   */
  public static function fuzzyMamdani(float $kognitif, float $psikomotorik, float $sosial): array
  {
    // ============================================
    // STEP 1: FUZZIFICATION
    // ============================================

    $mKognitif = [
      'rendah' => self::kognitifRendah($kognitif),
      'sedang' => self::kognitifSedang($kognitif),
      'tinggi' => self::kognitifTinggi($kognitif),
    ];

    $mPsikomotorik = [
      'belum_terampil' => self::psikomotorikBelumTerampil($psikomotorik),
      'terampil'         => self::psikomotorikTerampil($psikomotorik),
    ];

    $mSosial = [
      'butuh_bimbingan' => self::sosialButuhBimbingan($sosial),
      'baik'            => self::sosialBaik($sosial),
      'sangat_baik'     => self::sosialSangatBaik($sosial),
    ];

    // ============================================
    // STEP 2: RULE EVALUATION (54 Rules - All Combinations)
    // Using MIN operator for AND condition
    // ============================================
    $rules = self::getFuzzyRules();

    $alphaStimulasi = 0.0;
    $alphaBerkembang = 0.0;

    foreach ($rules as $rule) {
      // Get membership values for each antecedent
      $alpha = min(
        $mKognitif[$rule['kognitif']],
        $mPsikomotorik[$rule['psikomotorik']],
        $mSosial[$rule['sosial']],
      );

      // STEP 3: AGGREGATION using MAX operator
      if ($rule['output'] === 'stimulasi') {
        $alphaStimulasi = max($alphaStimulasi, $alpha);
      } else {
        $alphaBerkembang = max($alphaBerkembang, $alpha);
      }
    }

    // ============================================
    // STEP 4: DEFUZZIFICATION (Centroid / Center of Gravity)
    // ============================================
    $numerator = 0.0;
    $denominator = 0.0;
    $step = 0.5; // finer step for better accuracy

    for ($z = 0; $z <= 100; $z += $step) {
      // Compute clipped output membership values
      $muStimulasi = min(self::outputStimulasi($z), $alphaStimulasi);
      $muBerkembang = min(self::outputBerkembang($z), $alphaBerkembang);

      // Aggregated output (MAX of all clipped outputs)
      $muAgg = max($muStimulasi, $muBerkembang);

      $numerator += $z * $muAgg;
      $denominator += $muAgg;
    }

    $finalScore = $denominator > 0 ? $numerator / $denominator : 0;

    // Determine final label based on defuzzified score
    // Score < 60 → Stimulan, Score ≥ 60 → Berkembang (titik crossover kurva output)
    $finalLabel = $finalScore >= 60 ? 'Berkembang' : 'Stimulan';

    return [
      'score' => $finalScore,
      'label' => $finalLabel,
    ];
  }

  // ===================================================================
  // MEMBERSHIP FUNCTIONS - KOGNITIF (boundaries: 60, 80)
  // ===================================================================

  /**
   * μrendah(x):
   *   0          if x ≥ 80
   *   (80-x)/20  if 60 ≤ x ≤ 80
   *   1          if x ≤ 60
   */
  private static function kognitifRendah(float $x): float
  {
    if ($x >= 80) return 0.0;
    if ($x <= 60) return 1.0;
    return (80 - $x) / 20;
  }

  /**
   * μsedang(x):
   *   0          if x ≤ 40 or x ≥ 80
   *   (x-40)/20  if 40 < x < 60
   *   (80-x)/20  if 60 ≤ x < 80
   */
  private static function kognitifSedang(float $x): float
  {
    if ($x <= 40 || $x >= 80) return 0.0;
    if ($x < 60) return ($x - 40) / 20;
    return (80 - $x) / 20;
  }

  /**
   * μtinggi(x):
   *   0          if x ≤ 60
   *   (x-60)/20  if 60 < x < 80
   *   1          if x ≥ 80
   */
  private static function kognitifTinggi(float $x): float
  {
    if ($x <= 60) return 0.0;
    if ($x >= 80) return 1.0;
    return ($x - 60) / 20;
  }

  // ===================================================================
  // MEMBERSHIP FUNCTIONS - PSIKOMOTORIK (boundaries: 40, 80)
  // ===================================================================

  /**
   * μbelum_terampil(x):
   *   0          if x ≥ 80
   *   (80-x)/40  if 40 ≤ x ≤ 80
   *   1          if x ≤ 40
   */
  private static function psikomotorikBelumTerampil(float $x): float
  {
    if ($x >= 80) return 0.0;
    if ($x <= 40) return 1.0;
    return (80 - $x) / 40;
  }

  /**
   * μterampil(x):
   *   0          if x ≤ 40
   *   (x-40)/40  if 40 < x < 80
   *   1          if x ≥ 80
   */
  private static function psikomotorikTerampil(float $x): float
  {
    if ($x <= 40) return 0.0;
    if ($x >= 80) return 1.0;
    return ($x - 40) / 40;
  }

  // ===================================================================
  // MEMBERSHIP FUNCTIONS - SOSIAL EMOSIONAL (boundaries: 50, 60)
  // ===================================================================

  /**
   * μbutuh_bimbingan(x):
   *   0          if x ≥ 60
   *   (60-x)/10  if 50 ≤ x ≤ 60
   *   1          if x ≤ 50
   */
  private static function sosialButuhBimbingan(float $x): float
  {
    if ($x >= 60) return 0.0;
    if ($x <= 50) return 1.0;
    return (60 - $x) / 10;
  }

  /**
   * μbaik(x):
   *   0           if x ≤ 40 or x ≥ 60
   *   (x-40)/10   if 40 < x < 50
   *   (60-x)/10   if 50 ≤ x < 60
   */
  private static function sosialBaik(float $x): float
  {
    if ($x <= 40 || $x >= 60) return 0.0;
    if ($x < 50) return ($x - 40) / 10;
    return (60 - $x) / 10;
  }

  /**
   * μsangat_baik(x):
   *   0          if x ≤ 50
   *   (x-50)/10  if 50 < x < 60
   *   1          if x ≥ 60
   */
  private static function sosialSangatBaik(float $x): float
  {
    if ($x <= 50) return 0.0;
    if ($x >= 60) return 1.0;
    return ($x - 50) / 10;
  }

  // ===================================================================
  // MEMBERSHIP FUNCTIONS - OUTPUT (boundaries: 50, 70)
  // ===================================================================

  /**
   * μperlu_stimulasi(z):
   *   1          if z ≤ 50
   *   (70-z)/20  if 50 < z < 70
   *   0          if z ≥ 70
   */
  private static function outputStimulasi(float $z): float
  {
    if ($z <= 50) return 1.0;
    if ($z >= 70) return 0.0;
    return (70 - $z) / 20;
  }

  /**
   * μberkembang(z):
   *   0          if z ≤ 50
   *   (z-50)/20  if 50 < z < 70
   *   1          if z ≥ 70
   */
  private static function outputBerkembang(float $z): float
  {
    if ($z <= 50) return 0.0;
    if ($z >= 70) return 1.0;
    return ($z - 50) / 20;
  }

  // ===================================================================
  // FUZZY RULES - 18 Rules (Tabel 3.4)
  // ===================================================================

  /**
   * 18 expert-defined fuzzy rules (R1–R18) from Tabel 3.4
   *
   * R1–R9:   Output = Perlu Stimulasi
   * R10–R18: Output = Berkembang
   */
  private static function getFuzzyRules(): array
  {
    return [
      // R1: Kognitif Rendah, Psikomotorik Belum Terampil, Sosial Butuh Bimbingan → Perlu Stimulasi
      ['kognitif' => 'rendah', 'psikomotorik' => 'belum_terampil', 'sosial' => 'butuh_bimbingan', 'output' => 'stimulasi'],
      // R2: Kognitif Rendah, Psikomotorik Belum Terampil, Sosial Baik → Perlu Stimulasi
      ['kognitif' => 'rendah', 'psikomotorik' => 'belum_terampil', 'sosial' => 'baik', 'output' => 'stimulasi'],
      // R3: Kognitif Rendah, Psikomotorik Terampil, Sosial Butuh Bimbingan → Perlu Stimulasi
      ['kognitif' => 'rendah', 'psikomotorik' => 'terampil', 'sosial' => 'butuh_bimbingan', 'output' => 'stimulasi'],
      // R4: Kognitif Sedang, Psikomotorik Belum Terampil, Sosial Butuh Bimbingan → Perlu Stimulasi
      ['kognitif' => 'sedang', 'psikomotorik' => 'belum_terampil', 'sosial' => 'butuh_bimbingan', 'output' => 'stimulasi'],
      // R5: Kognitif Sedang, Psikomotorik Belum Terampil, Sosial Baik → Perlu Stimulasi
      ['kognitif' => 'sedang', 'psikomotorik' => 'belum_terampil', 'sosial' => 'baik', 'output' => 'stimulasi'],
      // R6: Kognitif Rendah, Psikomotorik Terampil, Sosial Baik → Perlu Stimulasi
      ['kognitif' => 'rendah', 'psikomotorik' => 'terampil', 'sosial' => 'baik', 'output' => 'stimulasi'],
      // R7: Kognitif Rendah, Psikomotorik Belum Terampil, Sosial Sangat Baik → Perlu Stimulasi
      ['kognitif' => 'rendah', 'psikomotorik' => 'belum_terampil', 'sosial' => 'sangat_baik', 'output' => 'stimulasi'],
      // R8: Kognitif Tinggi, Psikomotorik Belum Terampil, Sosial Butuh Bimbingan → Perlu Stimulasi
      ['kognitif' => 'tinggi', 'psikomotorik' => 'belum_terampil', 'sosial' => 'butuh_bimbingan', 'output' => 'stimulasi'],
      // R9: Kognitif Tinggi, Psikomotorik Belum Terampil, Sosial Baik → Perlu Stimulasi
      ['kognitif' => 'tinggi', 'psikomotorik' => 'belum_terampil', 'sosial' => 'baik', 'output' => 'stimulasi'],
      // R10: Kognitif Sedang, Psikomotorik Terampil, Sosial Butuh Bimbingan → Berkembang
      ['kognitif' => 'sedang', 'psikomotorik' => 'terampil', 'sosial' => 'butuh_bimbingan', 'output' => 'berkembang'],
      // R11: Kognitif Sedang, Psikomotorik Terampil, Sosial Baik → Berkembang
      ['kognitif' => 'sedang', 'psikomotorik' => 'terampil', 'sosial' => 'baik', 'output' => 'berkembang'],
      // R12: Kognitif Tinggi, Psikomotorik Terampil, Sosial Butuh Bimbingan → Berkembang
      ['kognitif' => 'tinggi', 'psikomotorik' => 'terampil', 'sosial' => 'butuh_bimbingan', 'output' => 'berkembang'],
      // R13: Kognitif Sedang, Psikomotorik Belum Terampil, Sosial Sangat Baik → Berkembang
      ['kognitif' => 'sedang', 'psikomotorik' => 'belum_terampil', 'sosial' => 'sangat_baik', 'output' => 'berkembang'],
      // R14: Kognitif Tinggi, Psikomotorik Belum Terampil, Sosial Sangat Baik → Berkembang
      ['kognitif' => 'tinggi', 'psikomotorik' => 'belum_terampil', 'sosial' => 'sangat_baik', 'output' => 'berkembang'],
      // R15: Kognitif Rendah, Psikomotorik Terampil, Sosial Sangat Baik → Berkembang
      ['kognitif' => 'rendah', 'psikomotorik' => 'terampil', 'sosial' => 'sangat_baik', 'output' => 'berkembang'],
      // R16: Kognitif Sedang, Psikomotorik Terampil, Sosial Sangat Baik → Berkembang
      ['kognitif' => 'sedang', 'psikomotorik' => 'terampil', 'sosial' => 'sangat_baik', 'output' => 'berkembang'],
      // R17: Kognitif Tinggi, Psikomotorik Terampil, Sosial Baik → Berkembang
      ['kognitif' => 'tinggi', 'psikomotorik' => 'terampil', 'sosial' => 'baik', 'output' => 'berkembang'],
      // R18: Kognitif Tinggi, Psikomotorik Terampil, Sosial Sangat Baik → Berkembang
      ['kognitif' => 'tinggi', 'psikomotorik' => 'terampil', 'sosial' => 'sangat_baik', 'output' => 'berkembang'],
    ];
  }
}
