<?php

namespace App\Filament\Resources\users\Pages;

use App\Filament\Resources\users\usersResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class Listusers extends ListRecords
{
    protected static string $resource = UsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
