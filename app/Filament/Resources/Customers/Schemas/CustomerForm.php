<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Customer Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->maxLength(100),

                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->required()
                            ->maxLength(20),

                        TextInput::make('adhar_no')
                            ->label('Aadhar No')
                            ->maxLength(20)
                            ->nullable(),

                        Textarea::make('address')
                            ->label('Address')
                            ->maxLength(255)
                            ->rows(3)
                            ->nullable(),

                        TextInput::make('opening_balance')
                            ->label('Opening Balance')
                            ->numeric()
                            ->default(0),

                    ])
                    ->columns(2)  // 2-column layout for cleaner UI
                    ->columnSpanFull(),
            ]);
    }
}
