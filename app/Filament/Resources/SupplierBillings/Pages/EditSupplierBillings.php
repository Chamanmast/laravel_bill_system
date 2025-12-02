<?php

namespace App\Filament\Resources\SupplierBillings\Pages;

use App\Filament\Resources\SupplierBillings\SupplierBillingsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSupplierBillings extends EditRecord
{
    protected static string $resource = SupplierBillingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
