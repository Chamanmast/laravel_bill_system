<?php

namespace App\Filament\Resources\Purities\Pages;

use App\Filament\Resources\Purities\PuritieResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPurities extends ListRecords
{
    protected static string $resource = PuritieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
