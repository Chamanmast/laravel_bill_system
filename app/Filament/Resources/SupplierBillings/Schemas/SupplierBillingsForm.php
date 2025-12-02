<?php

namespace App\Filament\Resources\SupplierBillings\Schemas;

use App\Models\Supplier;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SupplierBillingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2) // 2-column clean layout
            ->components([

                // Supplier Dropdown
                Select::make('supplier_id')
                    ->label('Supplier')
                    ->options(Supplier::pluck('shop_name', 'id'))
                    ->searchable()
                    ->required()
                    ->columnSpan(1),

                // Payment Mode (BADGE VALUES)
                Select::make('payment_mode')
                    ->label('Payment Mode')
                    ->options([
                        0 => 'Cash',
                        1 => 'Online',
                        2 => 'Cheque',
                    ])
                    ->required()
                    ->columnSpan(1),

                // Payment Amount
                TextInput::make('bill_amount')
                    ->label('Bill Amount (₹)')
                    ->numeric()
                    ->default(0)
                    ->required(),

                // Received Amount
                TextInput::make('paid')
                    ->label('Paid (₹)')
                    ->numeric()
                    ->default(0)
                    ->required(),

                // Transaction ID
                TextInput::make('transaction_id')
                    ->label('Transaction ID')
                    ->maxLength(255)
                    ->placeholder('Enter transaction reference...')
                    ->columnSpanFull(),

                // Bill Image Upload
                FileUpload::make('bill_image')
                    ->label('Bill Image')
                    ->image()
                    ->directory('supplier-bills')
                    ->columnSpanFull(),

                // Notes
                Textarea::make('note')
                    ->label('Note')
                    ->placeholder('Add any details...')
                    ->columnSpanFull(),
            ]);
    }
}
