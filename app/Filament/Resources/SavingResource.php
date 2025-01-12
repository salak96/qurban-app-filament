<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SavingResource\Pages;
use App\Models\Saving;
use App\Models\User;  // Impor model User untuk relasi
use App\Models\Animal;  // Impor model Animal untuk relasi
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextFilter;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SavingResource extends Resource
{
    protected static ?string $model = Saving::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    // Form untuk input data
  
    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('user_id')
                ->label('User')
                ->relationship('user', 'name') // Relasi ke model User
                ->required(),

            Forms\Components\Select::make('animal_id')
                ->label('Animal')
                ->relationship('animal', 'name') // Relasi ke model Animal
                ->required(),

            Forms\Components\TextInput::make('total_savings')
                ->label('Total Savings')
                ->placeholder('Enter total savings')
                ->required()
                ->numeric()
                ->afterStateUpdated(function ($state) {
                    // Validasi untuk memastikan nilai tidak kurang dari 0
                    if ($state < 0) {
                        throw new \Exception('Total savings cannot be less than 0.');
                    }
                }),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                ])
                ->required()
                ->default('pending'),
        ]);
}


    // Table untuk menampilkan data
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('animal.name')
                    ->label('Animal')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('total_savings')
                    ->label('Total Savings')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')),

                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Menentukan relasi dengan model lainnya
    public static function getRelations(): array
    {
        return [
            // Tambahkan relasi jika diperlukan
        ];
    }

    // Menentukan halaman untuk resource ini
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSavings::route('/'),
            'create' => Pages\CreateSaving::route('/create'),
            'edit' => Pages\EditSaving::route('/{record}/edit'),
        ];
    }
}
