<?php

namespace App\Filament\Resources\QurbanOrdersResource\Pages;

use App\Filament\Resources\QurbanOrdersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQurbanOrders extends EditRecord
{
    protected static string $resource = QurbanOrdersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
