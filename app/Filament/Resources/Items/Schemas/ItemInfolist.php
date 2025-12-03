<?php

namespace App\Filament\Resources\Items\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Item Details')
                    ->schema([

                        TextEntry::make('sku')
                            ->label('SKU'),

                        TextEntry::make('name')
                            ->label('Item Name'),

                        // Type
                        TextEntry::make('type.name')
                            ->label('Type')
                            ->placeholder('—'),

                        // Purity
                        TextEntry::make('purity.name')
                            ->label('Purity')
                            ->placeholder('—'),

                        // Unit
                        TextEntry::make('unit.name')
                            ->label('Unit')
                            ->placeholder('—'),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Pricing')
                    ->schema([

                        TextEntry::make('price')
                            ->label('Price'),

                        TextEntry::make('making_charge')
                            ->label('Making Charge'),

                        TextEntry::make('rate_per_gram')
                            ->label('Rate Per Gram'),

                        TextEntry::make('gst_percent')
                            ->label('GST %'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Weight & Stock')
                    ->schema([

                        TextEntry::make('gross_weight')
                            ->label('Gross Weight'),

                        TextEntry::make('net_weight')
                            ->label('Net Weight'),

                        TextEntry::make('stock_qty')
                            ->label('Stock Qty'),

                        // Product Status Badge
                        TextEntry::make('pstatus')
                            ->label('Product Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'in_stock' => 'success',
                                'sold' => 'danger',
                                'returned' => 'warning',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'in_stock' => 'In Stock',
                                'sold' => 'Sold',
                                'returned' => 'Returned',
                                default => 'Unknown',
                            }),

                        // Active Status Badge
                        TextEntry::make('status')
                            ->label('Active Status')
                            ->badge()
                            ->color(fn ($state): string => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn ($state): string => $state ? 'Active' : 'Inactive'),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Timestamps')
                    ->schema([

                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime(),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

            ]);
    }
}
