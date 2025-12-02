<?php

namespace App\Filament\Resources\SupplierBillings\Schemas;

use App\Models\Supplier;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SupplierBillingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Billing Details')
                    ->schema([

                        // Supplier Dropdown
                        Select::make('supplier_id')
                            ->label('Supplier')
                            ->native(false)
                            ->searchable()
                            ->options(
                                Supplier::pluck('shop_name', 'id')
                            )
                            ->placeholder('Select Supplier')
                            ->required(),

                        // Payment Mode
                        Select::make('payment_mode')
                            ->label('Payment Mode')
                            ->native(false)
                            ->options([
                                0 => 'Cash',
                                1 => 'Online',
                                2 => 'Cheque',
                            ])
                            ->placeholder('Select Payment Mode')
                            ->required(),

                        // Payment Amount
                        TextInput::make('payment')
                            ->label('Payment (₹)')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        // Received Amount
                        TextInput::make('received')
                            ->label('Received (₹)')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        // Transaction ID
                        TextInput::make('transaction_id')
                            ->label('Transaction ID')
                            ->maxLength(255)
                            ->placeholder('Enter transaction reference...'),

                        // Bill Image
                        FileUpload::make('bill_image')
                            ->label('Bill Image')
                            ->image()
                            ->directory('supplier-bills'),

                        // Note
                        Textarea::make('note')
                            ->label('Note')
                            ->placeholder('Write comments or remarks...'),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

            ]);
    }
}
