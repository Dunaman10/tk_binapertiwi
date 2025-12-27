<?php

namespace App\Filament\OrangTua\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $parentId = \Illuminate\Support\Facades\Auth::id();

        $childrenCount = \App\Models\Student::where('parent_id', $parentId)->count();

        $reportQuery = \App\Models\StudentDevelopment::whereHas('student', function ($query) use ($parentId) {
            $query->where('parent_id', $parentId);
        });

        $reportCount = $reportQuery->count();
        $averageScore = $reportQuery->avg('score');

        return [
            Stat::make('Total Anak', $childrenCount)
                ->description('Jumlah anak terdaftar')
                ->descriptionIcon('heroicon-m-user')
                ->color('primary'),

            Stat::make('Laporan Diterima', $reportCount)
                ->description('Total laporan perkembangan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),

            Stat::make('Rata-rata Nilai', number_format($averageScore ?? 0, 2))
                ->description('Rata-rata nilai keseluruhan')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('warning'),
        ];
    }
}
