<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;


class SupplierInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Supplier Information')
                    ->schema([

                        TextEntry::make('shop_name')
                            ->label('Shop Name'),

                        ImageEntry::make('bill_image')
                            ->label('Bill Image')
                            ->size(120),

                        TextEntry::make('phone')
                            ->label('Phone'),

                        TextEntry::make('email')
                            ->label('Email'),

                        TextEntry::make('address')
                            ->label('Address')
                            ->columnSpanFull(),

                        TextEntry::make('gst_no')
                            ->label('GST Number'),

                        TextEntry::make('account')
                            ->label('Account Details')
                            ->columnSpanFull(),



                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime()
                            ->columnSpanFull(),

                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime()
                            ->columnSpanFull(),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
