<?php

namespace App\Filament\KepalaSekolah\Resources;

use App\Filament\KepalaSekolah\Resources\ArchiveResource\Pages;
use App\Models\Archive;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ArchiveResource extends Resource
{
  protected static ?string $model = Archive::class;

  protected static ?string $navigationIcon = 'heroicon-o-archive-box';
  protected static ?string $navigationLabel = 'Data Arsip';
  protected static ?string $pluralLabel = 'Data Arsip';

  public static function form(Form $form): Form
  {
    return $form
      ->columns(1)
      ->schema([
        TextInput::make('title')
          ->label('Judul')
          ->required()
          ->maxLength(255),

        TextInput::make('description')
          ->label('Keterangan')
          ->required()
          ->maxLength(255),

        TextInput::make('created_by')
          ->label('Dibuat Oleh')
          ->required()
          ->maxLength(255),

        FileUpload::make('file_path')
          ->label('File')
          ->required()
          ->disk('public')
          ->directory('archive')
          ->storeFileNamesIn('original_filename'),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('title')
          ->label('Judul')
          ->searchable(),

        TextColumn::make('description')
          ->label('Keterangan'),

        TextColumn::make('created_by')
          ->label('Dibuat Oleh'),

        TextColumn::make('created_at')
          ->label('Tanggal')
          ->date('d M Y'),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\Action::make('download')
          ->label('Download Arsip')
          ->icon('heroicon-o-arrow-down-tray')
          ->color('')
          ->action(fn(Archive $record) => response()->download(
            storage_path('app/public/' . $record->file_path),
            $record->original_filename ?? basename($record->file_path)
          )),
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
      'index' => Pages\ListArchives::route('/'),
      // 'create' => Pages\CreateArchive::route('/create'),
      // 'edit' => Pages\EditArchive::route('/{record}/edit'),
    ];
  }
}
