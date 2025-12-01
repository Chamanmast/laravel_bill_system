<?php

namespace App\Filament\Resources\Purities\Pages;

use App\Filament\Resources\Purities\PuritieResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPuritie extends EditRecord
{
    protected static string $resource = PuritieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
