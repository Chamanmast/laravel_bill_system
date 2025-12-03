<?php

namespace App\Filament\Resources\Types\Schemas;

use App\Models\Category;
use App\Models\Type;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema; // Add this for query

class TypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Type Details')
                    ->schema([

                         // category Dropdown
                        Select::make('category_id')
                            ->label('category')
                            ->native(false)
                            ->searchable()
                            ->options(
                                Category::pluck('name', 'id')
                            )
                            ->placeholder('Select Category')
                            ->required(),

                        // Name
                         TextInput::make('name')
                            ->label('Item Name')
                            ->required(),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
