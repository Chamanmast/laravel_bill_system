<?php

namespace App\Filament\Resources\Purities\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PuritieInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Purity Information')
                    ->schema([

                         TextEntry::make('name')
                            ->label('Type Name'),

                        TextEntry::make('category.name')
                            ->label('category Name'),


                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
