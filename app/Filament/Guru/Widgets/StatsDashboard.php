<?php

namespace App\Filament\Guru\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $teacherId = \Illuminate\Support\Facades\Auth::id();

        $studentCount = \App\Models\Student::whereHas('class', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->count();

        $reportCount = \App\Models\StudentDevelopment::whereHas('student.class', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->count();

        $averageScore = \App\Models\StudentDevelopment::whereHas('student.class', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->avg('score');

        return [
            Stat::make('Total Siswa Saya', $studentCount)
                ->description('Jumlah anak di kelas anda')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Total Laporan', $reportCount)
                ->description('Total laporan perkembangan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),

            Stat::make('Rata-rata Nilai Kelas', number_format($averageScore ?? 0, 2))
                ->description('Rata-rata nilai perkembangan')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),
        ];
    }
}
