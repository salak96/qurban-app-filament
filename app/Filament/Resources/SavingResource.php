<?php
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\Saving;

class SavingResource extends Resource
{
    protected static ?string $model = Saving::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->required(),

                Forms\Components\Select::make('animal_id')
                    ->label('Animal')
                    ->relationship('animal', 'name')
                    ->required(),

                Forms\Components\TextInput::make('total_savings')
                    ->label('Total Savings')
                    ->required()
                    ->numeric()
                    ->extraAttributes([
                        'data-mask' => 'currency',
                        'id' => 'total_savings'
                    ]), // Menambahkan atribut data-mask untuk JavaScript

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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User')->sortable()->searchable(),
                TextColumn::make('animal.name')->label('Animal')->sortable()->searchable(),
                TextColumn::make('total_savings')
                    ->label('Total Savings')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => 'Rp. ' . number_format($state, 0, ',', '.')),
                TextColumn::make('status')->label('Status')->sortable()->searchable(),
                TextColumn::make('created_at')->label('Created At')->sortable()->searchable(),
            ]);
    }
}
