<?php

namespace App\Filament\Resources\Units\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Unit Details')
            ->schema([
                 TextInput::make('name')
                        ->label('Name')
                        ->maxLength(100)
                        ->required(),
                        TextInput::make('fname')
                        ->label('Full Name')
                        ->maxLength(100)
                        ->required(),
            ])
             ->columns(2)
             ->columnSpanFull(),
            ]);
    }
}
