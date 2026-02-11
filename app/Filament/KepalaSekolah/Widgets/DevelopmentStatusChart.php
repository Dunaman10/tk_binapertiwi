<?php

namespace App\Filament\KepalaSekolah\Widgets;

use App\Models\StudentDevelopment;
use Filament\Widgets\ChartWidget;

class DevelopmentStatusChart extends ChartWidget
{
  protected static ?string $heading = 'Distribusi Perkembangan Anak';
  protected static ?int $sort = 2;

  protected function getData(): array
  {
    $data = StudentDevelopment::query()
      ->selectRaw('status, count(*) as count')
      ->groupBy('status')
      ->pluck('count', 'status')
      ->toArray();

    return [
      'datasets' => [
        [
          'label' => 'Status Perkembangan',
          'data' => array_values($data),
          'backgroundColor' => [
            '#ef4444', // Red for Kurang
            '#eab308', // Yellow for Cukup
            '#22c55e', // Green for Baik
          ],
        ],
      ],
      'labels' => array_keys($data),
    ];
  }

  protected function getType(): string
  {
    return 'doughnut';
  }
}
