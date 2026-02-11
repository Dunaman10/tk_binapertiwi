<?php

namespace App\Filament\KepalaSekolah\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends BaseWidget
{
  protected function getStats(): array
  {
    return [
      Stat::make('Total Siswa', \App\Models\Student::count())
        ->description('Siswa terdaftar')
        ->descriptionIcon('heroicon-m-users')
        ->color('primary'),
      Stat::make('Total Kelas', \App\Models\SchoolClass::count())
        ->description('Kelas aktif')
        ->descriptionIcon('heroicon-m-academic-cap')
        ->color('success'),
      Stat::make('Dokumen Arsip', \App\Models\Archive::count())
        ->description('File tersimpan')
        ->descriptionIcon('heroicon-m-document-text')
        ->color('info'),
      Stat::make('Perkembangan Baik', \App\Models\StudentDevelopment::where('status', 'Baik')->count())
        ->description('Bulan ini')
        ->descriptionIcon('heroicon-m-star')
        ->color('success'),
    ];
  }
}
