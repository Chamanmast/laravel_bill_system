<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Supplier Details')
                    ->schema([

                        TextInput::make('shop_name')
                            ->label('Shop Name')
                            ->maxLength(150)
                            ->nullable(),
                        TextInput::make('phone')
                            ->label('Phone')
                            ->maxLength(20)
                            ->nullable(),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(100)
                            ->nullable(),

                        Textarea::make('address')
                            ->label('Address')
                            ->maxLength(255)
                            ->nullable(),

                        Textarea::make('gst_no')
                            ->label('GST Number')
                            ->maxLength(255)
                            ->nullable(),

                        Textarea::make('account')
                            ->label('Account Details')
                            ->maxLength(255)
                            ->nullable(),

                    ])
                    ->columns(2)          // 2-column layout for clean UI
                    ->columnSpanFull(),
            ]);
    }
}
