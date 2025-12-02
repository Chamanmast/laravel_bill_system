<?php

namespace App\Filament\Resources\Items\Tables;

use App\Models\Supplier;
use App\Models\Type;
use App\Models\Puritie;
use App\Models\Unit;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('image')
                    ->label('Image')
                    ->square()
                    ->size(50),

                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Item Name')
                    ->searchable()
                    ->sortable(),


                TextColumn::make('type.name')
                    ->label('Type')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('purity.name')
                    ->label('Purity')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '-';

                        $parts = explode('-', $state, 2);

                        // Trim spaces
                        $left  = trim($parts[0]);           // "24K"
                        $right = trim($parts[1] ?? '');     // "(99.9% Pure Gold)"

                        return "{$left}";
                    })
                    ->badge()
                    ->toggleable(),





                TextColumn::make('gross_weight')
                    ->label('Gross Wt')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('net_weight')
                    ->label('Net Wt')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('stock_qty')
                    ->label('Qty')
                    ->sortable(),
                   TextColumn::make('price')
                    ->label('Price')
                    ->money('INR')
                    ->sortable(),
                ToggleColumn::make('status')
                    ->label('Status')
                    ->offColor('success') // Optional: Color for "on" state
                    ->onColor('danger'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])

            ->filters([

                SelectFilter::make('type_id')
                    ->label('Filter by Subtype')
                    ->options(
                        Type::query()
                            ->whereNotNull('parent_id')
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->placeholder('All Subtypes'),


                SelectFilter::make('purity_id')
                    ->label('Filter by Purity')
                    ->options(
                        Puritie::query()
                            ->where('status', 0)
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->placeholder('All Purities'),

                SelectFilter::make('supplier_id')
                    ->label('Filter by Supplier')
                    ->options(
                        Supplier::query()
                            ->where('status', 0)
                            ->pluck('shop_name', 'id')
                    )
                    ->searchable()
                    ->placeholder('All Suppliers'),

                SelectFilter::make('unit_id')
                    ->label('Filter by Unit')
                    ->options(
                        Unit::query()
                            ->where('status', 0)
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->placeholder('All Units'),

            ])

            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
