<?php

namespace App\Filament\Resources\SupplierBillings;

use App\Filament\Resources\SupplierBillings\Pages\CreateSupplierBillings;
use App\Filament\Resources\SupplierBillings\Pages\EditSupplierBillings;
use App\Filament\Resources\SupplierBillings\Pages\ListSupplierBillings;
use App\Filament\Resources\SupplierBillings\Pages\ViewSupplierBillings;
use App\Filament\Resources\SupplierBillings\Schemas\SupplierBillingsForm;
use App\Filament\Resources\SupplierBillings\Schemas\SupplierBillingsInfolist;
use App\Filament\Resources\SupplierBillings\Tables\SupplierBillingsTable;
use App\Models\SupplierBillings;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SupplierBillingsResource extends Resource
{
    protected static ?string $model = SupplierBillings::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Stock Management';

    protected static ?string $recordTitleAttribute = 'SupplierBillings';

    protected static ?string $pluralModelLabel = 'Management Supplier Billings';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return SupplierBillingsForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SupplierBillingsInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SupplierBillingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSupplierBillings::route('/'),
            'create' => CreateSupplierBillings::route('/create'),
            'view' => ViewSupplierBillings::route('/{record}'),
            'edit' => EditSupplierBillings::route('/{record}/edit'),
        ];
    }
}
