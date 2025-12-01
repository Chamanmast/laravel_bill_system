<?php

namespace App\Filament\Resources\Purities\Pages;

use App\Filament\Resources\Purities\PuritieResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPuritie extends ViewRecord
{
    protected static string $resource = PuritieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
