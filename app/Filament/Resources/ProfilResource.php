<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfilResource\Pages;
use App\Models\Profil;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfilResource extends Resource
{
  protected static ?string $model = Profil::class;

  protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

  protected static ?string $navigationLabel = 'Profil';
  protected static ?string $pluralLabel = 'Profil Sekolah';
  protected static ?int $navigationSort = 1;


  public static function form(Form $form): Form
  {
    return $form
      ->columns(1)
      ->schema([
        TextInput::make('name')
          ->label('Nama Sekolah')
          ->required()
          ->maxLength(255),
        TextInput::make('address')
          ->label('Alamat Sekolah')
          ->required()
          ->maxLength(255),
        TextInput::make('phone')
          ->label('Telepon')
          ->numeric()
          ->required()
          ->maxLength(255),
        TextInput::make('email')
          ->label('Email Sekolah')
          ->required()
          ->email()
          ->maxLength(255),
        Textarea::make('description')
          ->label('Deskripsi Sekolah'),
        Textarea::make('vision')
          ->label('Visi Sekolah'),
        Textarea::make('mission')
          ->label('Misi Sekolah')
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->paginated(false)
      ->columns([
        TextColumn::make('name')
          ->label('Nama Sekolah'),
        TextColumn::make('address')
          ->label('Alamat'),
        TextColumn::make('phone')
          ->label('Telepon'),
        TextColumn::make('email')
          ->label('Email'),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\ViewAction::make()
          ->label('Lihat'),
        Tables\Actions\EditAction::make()
          ->label('Ubah'),
      ])
    ;
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
      'index' => Pages\ListProfils::route('/'),
      'create' => Pages\CreateProfil::route('/create'),
      // 'edit' => Pages\EditProfil::route('/{record}/edit'),
    ];
  }
}
