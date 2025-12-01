<?php

namespace App\Filament\Resources\Types\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\BadgeEntry;

class TypeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Type Information')
                    ->schema([

                        TextEntry::make('name')
                            ->label('Type Name'),

                        TextEntry::make('parent.name')
                            ->label('Parent Type')
                            ->placeholder('— None (Top Level) —'),




                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
