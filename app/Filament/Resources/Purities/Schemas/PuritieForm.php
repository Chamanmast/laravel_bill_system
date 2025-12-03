<?php

namespace App\Filament\Resources\Purities\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PuritieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('PuritieDetails')
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
                            ->label('Name')
                            ->required(),


                    ])
                    ->columns(2)
                    ->columnSpanFull(),

            ]);
    }
}
