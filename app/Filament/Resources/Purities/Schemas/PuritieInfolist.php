<?php

namespace App\Filament\Resources\Purities\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;


class PuritieInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Purity Information')
                    ->schema([

                        TextEntry::make('name')
                            ->label('Purity Name'),

                        TextEntry::make('type.name')
                            ->label('Type')
                            ->placeholder('— No Type —'),



                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
