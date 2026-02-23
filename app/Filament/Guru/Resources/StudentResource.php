<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\StudentResource\Pages;
use App\Filament\Guru\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Data Anak';
    protected static ?string $pluralLabel = 'Data Anak';
    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('class.teachers', function (Builder $query) {
                $query->where('users.id', \Illuminate\Support\Facades\Auth::id());
            });
    }

  public static function form(Form $form): Form
    {
        return $form
						->columns(1)
            ->schema([
                TextInput::make('name')
									->label('Nama')
									->required()
									->maxLength(255)
									->placeholder('masukkan nama anak'),

								DatePicker::make('birthdate')
								->label('Tanggal Lahir')
								->required(),

								Select::make('gender')
								->label('Jenis Kelamin')
								->required()
								->options([
									'P' => 'Perempuan',
									'L' => 'Laki-laki',
								]),

								Select::make('school_class_id')
								->label('Kelas')
									->required()
									->preload()
									->searchable()
									->relationship('class', 'student_class'),

								Select::make('parent_id')
									->label('Orang Tua')
									->required()
									->preload()
									->searchable()
									->relationship('parent', 'name'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Anak')
                    ->searchable(),
                TextColumn::make('class.student_class')
                    ->label('Kelas')
                    ->searchable(),
                TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                        default => $state,
                    }),
                TextColumn::make('parent.name')
                    ->label('Orang Tua')
                    ->searchable(),
                TextColumn::make('birthdate')
                    ->label('Tanggal Lahir')
                    ->date('d M Y'),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            // 'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
