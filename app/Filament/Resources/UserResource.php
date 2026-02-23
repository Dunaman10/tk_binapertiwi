<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
  protected static ?string $model = User::class;

  protected static ?string $navigationIcon = 'heroicon-o-users';

  protected static ?string $navigationLabel = 'Data Pengguna';

  protected static ?string $pluralLabel = 'Data Pengguna';
  protected static ?int $navigationSort = 8;



  public static function form(Form $form): Form
  {
    return $form
      ->columns(1)
      ->schema([
        TextInput::make('name')
          ->label('Nama')
          ->required()
          ->regex('/^[a-zA-Z\s\.\,\']+$/')
          ->validationMessages([
            'regex' => 'Nama hanya boleh berisi huruf, spasi, dan tanda baca (titik, koma).',
          ])
          ->maxLength(255),

        TextInput::make('email')
          ->label('Email')
          ->email()
          ->required()
          ->maxLength(255),

        Select::make('role')
          ->label('Peran')
          ->required()
          ->options([
            'admin' => 'Admin',
            'guru' => 'Guru',
            'orang_tua' => 'Orang Tua',
            'kepala_sekolah' => 'Kepala Sekolah',
          ])
          ->live(),

        TextInput::make('password')
          ->label('Kata Sandi')
          ->password()
          ->required(fn (string $operation): bool => $operation === 'create')
          ->maxLength(255)
          ->dehydrated(fn (?string $state): bool => filled($state))
          ->hidden(fn (string $operation): bool => $operation === 'edit'),

        Toggle::make('is_responsible')
          ->label('Penanggung Jawab Perkembangan Anak')
          ->helperText('Aktifkan jika guru ini bertanggung jawab untuk menginput data perkembangan anak.')
          ->default(false),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')
          ->label('Nama')
          ->searchable(),

        TextColumn::make('email')
          ->label('Email')
          ->searchable(),

        TextColumn::make('role')
          ->label('Peran')
          ->searchable(),

        IconColumn::make('is_responsible')
          ->label('Penanggung Jawab')
          ->alignCenter()
          ->boolean()
          ->trueIcon('heroicon-o-check-circle')
          ->falseIcon('heroicon-o-x-circle')
          ->trueColor('success')
          ->falseColor('danger'),
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
      'index' => Pages\ListUsers::route('/'),
      // 'create' => Pages\CreateUser::route('/create'),
      // 'edit' => Pages\EditUser::route('/{record}/edit'),
    ];
  }
}
