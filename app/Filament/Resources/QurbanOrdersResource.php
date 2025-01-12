<?php
namespace App\Filament\Resources;

use App\Filament\Resources\QurbanOrdersResource\Pages;
use App\Models\QurbanOrders;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QurbanOrdersResource extends Resource
{
    protected static ?string $model = QurbanOrders::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name') // Menggunakan relasi yang benar di model
                    ->required(),
    
                Forms\Components\Select::make('animal_id')
                    ->label('Animal')
                    ->relationship('animal', 'name') // Menggunakan relasi yang benar di model
                    ->required(),
    
                Forms\Components\Select::make('savings_id')
                    ->label('Savings')
                    ->relationship('savings', 'total_savings') // Menggunakan relasi yang benar di model
                    ->required()
                    // Gunakan mask untuk format uang Rupiah
                    ->afterStateHydrated(function ($state) {
                        return $state ? 'Rp ' . number_format($state, 0, ',', '.') : null;
                    }),
                    Forms\Components\Select::make('order_status')
                    ->label('Order Status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                    ])
                    ->default('pending')
                    ->required(),
    
                Forms\Components\DateTimePicker::make('order_date')
                    ->label('Order Date')
                    ->required()
                    ->default(now()), // Default waktu sekarang

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('User Name') // Menampilkan nama user terkait
                    ->sortable()
                    ->searchable(),

                TextColumn::make('animal.name')
                    ->label('Animal Name') // Menampilkan nama animal terkait
                    ->sortable()
                    ->searchable(),

                TextColumn::make('savings.total_savings')
                    ->label('Total Savings') // Menampilkan total savings
                    ->sortable()
                    ->searchable()
                    // Formatkan nilai dalam format Rupiah
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                TextColumn::make('order_status')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('order_date')  // Menampilkan tanggal pemesanan
                    ->label('Order Date')
                    ->sortable()
                    ->searchable()
                    ->date(), // Formatkan tanggal dengan .date()
            ])
            ->filters([
                // Anda bisa menambahkan filter jika diperlukan
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
            'index' => Pages\ListQurbanOrders::route('/'),
            'create' => Pages\CreateQurbanOrders::route('/create'),
            'edit' => Pages\EditQurbanOrders::route('/{record}/edit'),
        ];
    }
}
