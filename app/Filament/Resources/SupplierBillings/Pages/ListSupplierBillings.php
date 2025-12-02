<?php

namespace App\Filament\Resources\SupplierBillings\Pages;

use App\Filament\Resources\SupplierBillings\SupplierBillingsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSupplierBillings extends ListRecords
{
    protected static string $resource = SupplierBillingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
