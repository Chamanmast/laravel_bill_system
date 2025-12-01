<?php

namespace App\Filament\Resources\Types\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use App\Models\Type; // Add this for query

class TypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Type Details')
                    ->schema([

                        Select::make('parent_id')
                            ->label('Parent Type')
                            ->native(false)
                            ->searchable()
                            ->options(
                                Type::query()
                                    ->whereNull('parent_id')   // Only top-level parents
                                    ->pluck('name', 'id')
                            )
                            ->placeholder('Select Parent (optional)')
                            ->nullable(),

                        TextInput::make('name')
                            ->label('Type Name')
                            ->maxLength(100)
                            ->required(),



                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
