<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SavingsResource\Pages;
use App\Filament\Resources\SavingsResource\RelationManagers;
use App\Models\Saving;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Builder;

class SavingsResource extends Resource
{
    protected static ?string $model = Saving::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Form untuk menambah atau mengedit data
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name') // Menghubungkan dengan relasi user
                    ->required(),
                
                Forms\Components\Select::make('animal_id')
                    ->label('Animal')
                    ->relationship('animal', 'name') // Menghubungkan dengan relasi animal
                    ->required(),
                
                Forms\Components\TextInput::make('total_savings')
                    ->label('Total Savings')
                    ->numeric()
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }

    // Tabel untuk menampilkan data
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('animal.name')
                    ->label('Animal')
                    ->sortable(),
                
                // Format kolom 'total_savings' menjadi Rupiah
                Tables\Columns\TextColumn::make('total_savings')
                    ->label('Total Savings')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')), // Format uang Rupiah
                
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),
            ])
            ->filters([
                // Filter berdasarkan status
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->label('Status'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Relasi dengan model lain, jika diperlukan
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // Menentukan halaman-halaman yang ada
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSavings::route('/'),
            'create' => Pages\CreateSavings::route('/create'),
            'edit' => Pages\EditSavings::route('/{record}/edit'),
        ];
    }
}
