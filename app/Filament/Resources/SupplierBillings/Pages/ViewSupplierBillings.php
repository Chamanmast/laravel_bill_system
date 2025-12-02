<?php

namespace App\Filament\Resources\SupplierBillings\Pages;

use App\Filament\Resources\SupplierBillings\SupplierBillingsResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSupplierBillings extends ViewRecord
{
    protected static string $resource = SupplierBillingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
