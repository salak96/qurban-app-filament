<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;  // Impor yang benar untuk TextColumn
use Filament\Forms\Components\TextInput;  // Impor yang benar untuk TextInput
use Filament\Forms\Components\Textarea;  // Impor yang benar untuk Textarea
use Filament\Forms\Components\Select;    // Impor yang benar untuk Select
use Illuminate\Support\Facades\Hash;     // Impor untuk Hashing password

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('username')
                    ->label('Full Name')
                    ->placeholder('Enter full name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email Address')
                    ->placeholder('example@domain.com')
                    ->required()
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('Phone Number')
                    ->placeholder('Enter phone number')
                    ->tel()
                    ->required()
                    ->maxLength(15),

                Textarea::make('address')
                    ->label('Complete Address')
                    ->placeholder('Enter complete address')
                    ->rows(3)
                    ->nullable(),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))  // Hash password
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255),

                Select::make('role')
                    ->label('User Role')
                    ->options([
                        'admin' => 'Administrator',
                        'user' => 'Regular User'
                    ])
                    ->required()
                    ->default('user')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('username')  // Gunakan 'username' sebagai kolom
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->sortable(),
                TextColumn::make('address')
                    ->sortable(),
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

    public static function getRelations(): array
    {
        return [
            // Jika ada relasi model, tambahkan di sini
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
