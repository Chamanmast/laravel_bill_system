<?php

namespace App\Filament\Resources\Items\Schemas;

use App\Models\Puritie;
use App\Models\Supplier;
use App\Models\Type;
use App\Models\Unit;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;


class ItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Basic Information')
                    ->schema([

                        Select::make('supplier_id')
                            ->label('Supplier')
                            ->options(Supplier::where('status', 0)->pluck('shop_name', 'id'))
                            ->searchable()
                            ->native(false),

                        // ===========================
                        //  TYPE SELECT (Parent)
                        // ===========================
                        Select::make('type_id')
                            ->label('Type')
                            ->options(
                                Type::whereNull('parent_id')->where('status', 0)->pluck('name', 'id')
                            )
                            ->searchable()
                            ->native(false)
                            ->reactive()
                            ->afterStateUpdated(
                                fn(callable $set) =>
                                $set('subtype_id', null)
                            )
                            ->afterStateHydrated(function ($state, callable $set) {
                                if ($state) {
                                    // Find saved type (child id)
                                    $child = Type::find($state);

                                    // If this type has a parent → means it's a subtype
                                    if ($child && $child->parent_id) {
                                        // Set parent type
                                        $set('type_id', $child->parent_id);

                                        // Set subtype field
                                        $set('subtype_id', $child->id);
                                    }
                                }
                            }),

                        // ===========================
                        //  SUBTYPE SELECT (AJAX)
                        // ===========================
                        Select::make('subtype_id')
                            ->label('Subtype')
                            ->options(
                                fn(callable $get) =>
                                Type::where('parent_id', $get('type_id'))->where('status', 0)->pluck('name', 'id')
                            )
                            ->searchable()
                            ->native(false)
                            ->reactive()
                            ->placeholder('Select Type First')
                            ->disabled(fn(callable $get) => empty($get('type_id'))),

                        Select::make('purity_id')
                            ->label('Purity')
                            ->options(Puritie::where('status', 0)->pluck('name', 'id'))
                            ->searchable()
                            ->native(false),

                        Select::make('unit_id')
                            ->label('Unit')
                            ->options(Unit::where('status', 0)->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->native(false),

                        TextInput::make('sku')
                            ->label('SKU')
                            ->required(),

                        TextInput::make('name')
                            ->label('Item Name')
                            ->required(),

                        FileUpload::make('image')
                            ->label('Item Image')
                            ->image()
                            ->directory('items'),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Pricing & Charges')
                    ->schema([

                        TextInput::make('price')
                            ->label('Price')
                            ->numeric(),
                        TextInput::make('making_charge')
                            ->label('Making Charge')
                            ->numeric()
                            ->default(0),
                        TextInput::make('rate_per_gram')
                            ->label('Rate per Gram')
                            ->numeric()
                            ->default(0),
                        TextInput::make('gst_percent')
                            ->label('GST %')
                            ->numeric()
                            ->default(0),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Weight & Stock')
                    ->schema([

                        TextInput::make('gross_weight')
                            ->label('Gross Weight')
                            ->numeric()
                            ->required(),
                        TextInput::make('net_weight')
                            ->label('Net Weight')
                            ->numeric()
                            ->required(),
                        TextInput::make('stock_qty')
                            ->label('Stock Quantity')
                            ->numeric()
                            ->default(1),

                        Select::make('pstatus')
                            ->label('Product Status')
                            ->options([
                                'in_stock' => 'In Stock',
                                'sold'     => 'Sold',
                                'returned' => 'Returned',
                            ])
                            ->native(false)
                            ->default('in_stock'),



                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
