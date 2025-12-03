<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category Information')
                    ->schema([

                         TextEntry::make('name')
                            ->label('Type Name'),




                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
