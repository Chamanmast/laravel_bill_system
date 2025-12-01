<?php

namespace App\Filament\Resources\Purities\Schemas;

use App\Models\Type;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class PuritieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Purity Details')
                    ->schema([

                        Select::make('type_id')
                            ->label('Type')
                            ->native(false)
                            ->searchable()
                            ->options(
                                Type::pluck('name', 'id') // Show all types
                            )
                            ->placeholder('Select Type')
                            ->required(),

                        TextInput::make('name')
                            ->label('Purity Name')
                            ->maxLength(255)
                            ->required(),



                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
