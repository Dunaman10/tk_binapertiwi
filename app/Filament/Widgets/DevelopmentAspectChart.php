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
        $avgPsikomotorik = StudentDevelopment::avg('psikomotorik');
        $avgKognitif = StudentDevelopment::avg('kognitif');
        $avgSosial = StudentDevelopment::avg('sosial_emosional');

        return [
            'datasets' => [
                [
                    'label' => 'Rata-rata Nilai',
                    'data' => [
                        $avgPsikomotorik, 
                        $avgKognitif, 
                        $avgSosial
                    ],
                    'backgroundColor' => [
                        '#3b82f6', 
                        '#8b5cf6', 
                        '#ec4899'
                    ],
                ],
            ],
            'labels' => ['Psikomotorik', 'Kognitif', 'Sosial Emosional'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
