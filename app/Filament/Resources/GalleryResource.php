<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Filament\Resources\GalleryResource\RelationManagers;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GalleryResource extends Resource
{
  protected static ?string $model = Gallery::class;

  protected static ?string $navigationIcon = 'heroicon-o-photo';

  protected static ?string $navigationLabel = 'Galeri';
  protected static ?string $pluralLabel = 'Galeri';
  protected static ?int $navigationSort = 7;

  public static function form(Form $form): Form
  {
    return $form
      ->columns(1)
      ->schema([
        TextInput::make('title')
          ->label('Judul')
          ->required(),
        Textarea::make('description')
          ->label('Deskripsi'),
        FileUpload::make('image_path')
          ->label('Gambar')
          ->required()
          ->image()
          ->disk('public')
          ->directory('gallery')
          ->maxSize('2024'),
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
          ->label('Deskripsi')
          ->placeholder('Tidak ada deskripsi')
          ->searchable(),
        ImageColumn::make('image_path')
          ->label('Gambar')
          ->disk('public'),
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

  public static function infolist(Infolist $infolist): Infolist
  {
    return $infolist
      ->columns(1)
      ->schema([
        TextEntry::make('title')
          ->label('Judul'),
        TextEntry::make('description')
          ->label('Deskripsi'),
        ImageEntry::make('image_path')
          ->label('Gambar')
          ->disk('public')
          ->columnSpanFull(),
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
      'index' => Pages\ListGalleries::route('/'),
      // 'create' => Pages\CreateGallery::route('/create'),
      // 'edit' => Pages\EditGallery::route('/{record}/edit'),
    ];
  }
}
