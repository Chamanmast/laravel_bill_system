<?php

namespace App\Filament\Resources\Items\Schemas;

use App\Models\Category;
use App\Models\Puritie;
use App\Models\Type;
use App\Models\Unit;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Basic Information')
                    ->schema([

                        // ===========================
                        //  CATEGORY SELECT
                        // ===========================
                        Select::make('category_id')
                            ->label('Category')
                            ->options(Category::active()->pluck('name', 'id'))
                            ->searchable()
                            ->native(false)
                            ->reactive()
                            ->placeholder('Select Category')
                            ->afterStateUpdated(function (callable $set) {
                                $set('type_id', null);
                                $set('purity_id', null);
                            }),


                        // ===========================
                        //  TYPE SELECT
                        // ===========================
                        Select::make('type_id')
                            ->label('Type')
                            ->options(
                                fn(callable $get) =>
                                $get('category_id')
                                    ? Type::active()
                                    ->where('category_id', $get('category_id'))
                                    ->pluck('name', 'id')
                                    : []
                            )
                            ->searchable()
                            ->native(false)
                            ->reactive()
                            ->placeholder('Select Category First')
                            ->afterStateUpdated(fn(callable $set) => $set('purity_id', null))
                            ->disabled(fn(callable $get) => ! filled($get('category_id'))),


                        // ===========================
                        //  PURITY SELECT
                        // ===========================
                        Select::make('purity_id')
                            ->label('Purity')
                            ->options(
                                fn(callable $get) =>
                                $get('category_id')
                                    ? Puritie::active()
                                    ->where('category_id', $get('category_id'))
                                    ->pluck('name', 'id')
                                    : []
                            )
                            ->searchable()
                            ->native(false)
                            ->placeholder('Select Type First')
                            ->disabled(fn(callable $get) => ! filled($get('type_id'))),

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
                                'sold' => 'Sold',
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
