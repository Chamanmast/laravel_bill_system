<?php

namespace App\Filament\Resources\SupplierBillings\Tables;

use App\Models\Supplier;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SupplierBillingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Supplier Name
                TextColumn::make('supplier.shop_name')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable(),

                // Payment
                TextColumn::make('details')
                    ->label('Details')
                    ->getStateUsing(function ($record) {

                        return '
            <div class="product-details text-sm leading-5">
                <strong class="text-info">Payment Mode:</strong> '.MODE[$record->payment_mode].'<br>
                <strong class="text-success">Bill Amount:</strong> '.MONEY.($record->bill_amount ?? $record->payment).'<br>
                <strong class="text-secondary">Paid Amount:</strong> '.MONEY.($record->paid ?? $record->received).'<br>
                <strong class="text-warning">Created At:</strong> '.$record->created_at->format('d-M-Y').'<br>
                <strong class="text-danger">Updated At:</strong> '.$record->updated_at->format('d-M-Y').'
            </div>
        ';
                    })
                    ->html()
                    ->wrap(),  // ⬅ Allows multi-line text

                TextColumn::make('supplier.shop_name')
                    ->label('Supplier Shop Name')
                    ->searchable()
                    ->sortable(),

                // Transaction ID
                TextColumn::make('transaction_id')
                    ->label('Txn ID')
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
