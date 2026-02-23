<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassResource\Pages;
use App\Filament\Resources\ClassResource\RelationManagers;
use App\Models\SchoolClass;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassResource extends Resource
{
  protected static ?string $model = SchoolClass::class;

  protected static ?string $navigationIcon = 'heroicon-o-building-office';
  protected static ?string $navigationLabel = 'Data Kelas';
  protected static ?string $pluralLabel = 'Data Kelas';
  protected static ?int $navigationSort = 2;


  public static function form(Form $form): Form
  {
    return $form
      ->columns(1)
      ->schema([
        TextInput::make('student_class')
          ->label('Nama Kelas')
          ->required()
          ->maxLength(255),
        Select::make('teachers')
          ->label('Pengajar')
          ->relationship('teachers', 'name', fn(Builder $query) => $query->where('role', 'guru'))
          ->multiple()
          ->searchable()
          ->preload()
          ->required(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('student_class')
          ->label('Nama Kelas')
          ->searchable(),
        Tables\Columns\TextColumn::make('teachers_display')
          ->label('Pengajar')
          ->getStateUsing(function ($record) {
            $names = $record->teachers->pluck('name');
            if ($names->count() <= 2) {
              return $names->implode(', ');
            }
            return $names->take(2)->implode(', ') . ', ...';
          })
          ->tooltip(function ($record) {
            return $record->teachers->pluck('name')->implode(', ');
          })
          ->searchable(query: function (Builder $query, string $search): Builder {
            return $query->whereHas('teachers', function (Builder $q) use ($search) {
              $q->where('name', 'like', "%{$search}%");
            });
          }),
      ])
      ->filters([
        //
      ])
      ->actions([
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
      'index' => Pages\ListClasses::route('/'),
      // 'create' => Pages\CreateClass::route('/create'),
      // 'edit' => Pages\EditClass::route('/{record}/edit'),
    ];
  }
}
