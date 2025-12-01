<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SiteSettingsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('logo'),
                TextEntry::make('favicon'),
                TextEntry::make('site_title'),
                TextEntry::make('app_name'),
                TextEntry::make('about'),
                TextEntry::make('phone'),
                TextEntry::make('address'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
