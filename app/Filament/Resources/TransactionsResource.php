<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionsResource\Pages;
use App\Models\Transactions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;

class TransactionsResource extends Resource
{
    protected static ?string $model = Transactions::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->required(),

                Forms\Components\Select::make('saving_id')
                    ->label('Saving')
                    ->relationship('saving', 'total_savings')
                    ->required(),

                Forms\Components\TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->rule('integer') // Pastikan hanya menerima angka bulat
                    ->required()
                    ->prefix('Rp.') 
                    ->live() 
                    ->afterStateUpdated(fn ($state, callable $set) => 
                        $set('amount', number_format((int) str_replace(['Rp.', '.', ','], '', $state), 0, ',', '.'))
                    ),

                Forms\Components\DateTimePicker::make('transaction_date')
                    ->label('Transaction Date')
                    ->required()
                    ->default(now()), 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('saving.total_savings')
                    ->label('Total Savings')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp. ' . number_format((float) $state, 0, ',', '.')),

                TextColumn::make('amount')
                    ->label('Amount')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp. ' . number_format((float) $state, 0, ',', '.')),

                TextColumn::make('transaction_date')
                    ->label('Transaction Date')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\Filter::make('transaction_date')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('to'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(isset($data['from']), fn ($query) => $query->whereDate('transaction_date', '>=', $data['from']))
                            ->when(isset($data['to']), fn ($query) => $query->whereDate('transaction_date', '<=', $data['to']));
                    }),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransactions::route('/create'),
            'edit' => Pages\EditTransactions::route('/{record}/edit'),
        ];
    }
}
