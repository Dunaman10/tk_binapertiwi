<?php

namespace App\Filament\Widgets;

use App\Models\StudentDevelopment;
use Filament\Widgets\ChartWidget;

class DevelopmentAspectChart extends ChartWidget
{
    protected static ?string $heading = 'Rata-rata Nilai Aspek Perkembangan';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $avgMotorik = StudentDevelopment::avg('motorik');
        $avgKognitif = StudentDevelopment::avg('kognitif');
        $avgBahasa = StudentDevelopment::avg('bahasa');
        $avgSosial = StudentDevelopment::avg('sosial_emosional');

        return [
            'datasets' => [
                [
                    'label' => 'Rata-rata Nilai',
                    'data' => [
                        $avgMotorik, 
                        $avgKognitif, 
                        $avgBahasa, 
                        $avgSosial
                    ],
                    'backgroundColor' => [
                        '#3b82f6', 
                        '#8b5cf6', 
                        '#f97316', 
                        '#ec4899'
                    ],
                ],
            ],
            'labels' => ['Motorik', 'Kognitif', 'Bahasa', 'Sosial Emosional'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
