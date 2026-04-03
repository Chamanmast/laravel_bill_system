<?php

namespace App\Filament\Resources\users\Pages;

use App\Filament\Resources\users\usersResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class Viewusers extends ViewRecord
{
    protected static string $resource = UsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
